<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 05/01/2019
 * Time: 20:49
 */

namespace App\Logic\MDT\IO;


use App\Logic\MDT\Conversion;
use App\Logic\MDT\Data\MDTDungeon;
use App\Logic\MDT\Exception\ImportWarning;
use App\Logic\Utils\Stopwatch;
use App\Models\Brushline;
use App\Models\DungeonRoute;
use App\Models\Enemy;
use App\Models\Path;
use App\Service\Season\SeasonService;
use Illuminate\Support\Collection;

/**
 * This file handles any and all conversion from DungeonRoutes to MDT Export strings and vice versa.
 * @package App\Logic\MDT
 * @author Wouter
 * @since 05/01/2019
 */
class ExportString extends MDTBase
{


    /** @var $_encodedString string The MDT encoded string that's currently staged for conversion to a DungeonRoute. */
    private $_encodedString;

    /** @var DungeonRoute The route that's currently staged for conversion to an encoded string. */
    private DungeonRoute $_dungeonRoute;

    /** @var SeasonService Used for grabbing info about the current M+ season. */
    private SeasonService $_seasonService;


    function __construct(SeasonService $seasonService)
    {
        $this->_seasonService = $seasonService;
    }

    /**
     * @param Collection $warnings
     * @return array
     */
    private function _extractObjects(Collection $warnings): array
    {
        $result = [];

        // Lua is 1 based, not 0 based
        $mapIconIndex = 1;
        foreach ($this->_dungeonRoute->mapicons as $mapIcon) {
            $mdtCoordinates = Conversion::convertLatLngToMDTCoordinate(['lat' => $mapIcon->lat, 'lng' => $mapIcon->lng]);

            $result[$mapIconIndex] = [
                'n' => true,
                'd' => [
                    1 => $mdtCoordinates['x'],
                    2 => $mdtCoordinates['y'],
                    3 => $mapIcon->floor->index,
                    4 => true,
                    5 => $mapIcon->comment
                ]
            ];
            $mapIconIndex++;
        }

        $lines = $this->_dungeonRoute->brushlines->merge($this->_dungeonRoute->paths);

        $lineIndex = 1;
        foreach ($lines as $line) {
            /** @var Path|Brushline $line */

            $mdtLine = [
                'd' => [
                    1 => $line->polyline->weight,
                    2 => 1,
                    3 => $line->floor->index,
                    4 => true,
                    5 => strpos($line->polyline->color, '#') === 0 ? substr($line->polyline->color, 1) : $line->polyline->color,
                    6 => -8,
                ],
                't' => [
                    1 => 0
                ],
                'l' => []
            ];

            if ($line instanceof Brushline) {
                $mdtLine['d'][7] = true;
            }

            $vertexIndex = 1;
            $vertices = json_decode($line->polyline->vertices_json, true);
            foreach ($vertices as $latLng) {
                $mdtCoordinates = Conversion::convertLatLngToMDTCoordinate($latLng);
                // Post increment
                $mdtLine['l'][$vertexIndex++] = $mdtCoordinates['x'];
                $mdtLine['l'][$vertexIndex++] = $mdtCoordinates['y'];
            }

            $result[$lineIndex++] = $mdtLine;
        }

        return $result;
    }

    /**
     * @param Collection $warnings
     * @return array
     */
    private function _extractPulls(Collection $warnings): array
    {
        $result = [];

        // Get a list of MDT enemies as Keystone.guru enemies - we need this to know how to convert
        $mdtEnemies = (new MDTDungeon($this->_dungeonRoute->dungeon->name))
            ->getClonesAsEnemies($this->_dungeonRoute->dungeon->floors);

        // Lua is 1 based, not 0 based
        $pullIndex = 1;
        /** @var Collection|Enemy[] $killZones */
        $killZones = $this->_dungeonRoute->killzones()->with(['enemies'])->get();
        foreach ($killZones as $killZone) {
            $pull = [];

            // Lua is 1 based, not 0 based
            $enemyIndex = 1;
            foreach ($killZone->enemies as $enemy) {
                // MDT does not handle prideful NPCs
                if ($enemy->npc->isPrideful()) {
                    Stopwatch::pause('pridefulCheck');
                    continue;
                }

                // Find the MDT enemy - we need to know the mdt_npc_index
                $mdtNpcIndex = -1;
                foreach ($mdtEnemies as $mdtEnemyCandidate) {
                    if ($mdtEnemyCandidate->npc_id === $enemy->npc_id && $mdtEnemyCandidate->mdt_id === $enemy->mdt_id) {
                        $mdtNpcIndex = $mdtEnemyCandidate->mdt_npc_index;
                        break;
                    }
                }

                // If we couldn't find the enemy in MDT..
                if ($mdtNpcIndex === -1) {
                    $warnings->push(new ImportWarning(sprintf(__('Pull %s'), $pullIndex),
                        sprintf(__('Unable to find MDT equivalent for Keystone.guru enemy with NPC %s (enemy_id: %s, npc_id: %s).'), $enemy->npc->name, $enemy->id, $enemy->npc_id),
                        ['details' => __('This indicates that your route kills an enemy of which its NPC is known to MDT, 
                        but Keystone.guru hasn\'t coupled that enemy to an MDT equivalent yet (or it does not exist in MDT).')]
                    ));
                }

                // Create an array if it didn't exist yet
                if (!isset($pull[$mdtNpcIndex])) {
                    $pull[$mdtNpcIndex] = [];
                }

                // For this enemy, kill this clone
                $pull[$mdtNpcIndex][$enemyIndex++] = $enemy->mdt_id;
            }

            $pull['color'] = strpos($killZone->color, '#') === 0 ? substr($killZone->color, 1) : $killZone->color;

            $result[$pullIndex++] = $pull;
        }
        return $result;
    }


    /**
     * Gets the MDT encoded string based on the currently set DungeonRoute.
     * @param Collection $warnings
     * @return string
     */
    public function getEncodedString(Collection $warnings)
    {
//        $lua = $this->_getLua();

        $mdtObject = [
            //
            'objects'    => $this->_extractObjects($warnings),
            // M+ level
            'difficulty' => $this->_dungeonRoute->level_min,
            'week'       => $this->_dungeonRoute->affixgroups->isEmpty() ? 1 :
                Conversion::convertAffixGroupToWeek($this->_seasonService, $this->_dungeonRoute->affixes->first()),
            'value'      => [
                'currentDungeonIdx' => $this->_dungeonRoute->dungeon->mdt_id,
                'selection'         => [],
                'currentPull'       => 1,
                'teeming'           => $this->_dungeonRoute->teeming,
                // Legacy - we don't do anything with it
                'riftOffsets'       => [

                ],
                'pulls'             => $this->_extractPulls($warnings),
                'currentSublevel'   => 1
            ],
            'text'       => $this->_dungeonRoute->title,
            'mdi'        => [
                'freeholdJoined' => false,
                'freehold'       => 1,
                'beguiling'      => 1
            ],
            // Leave a consistent UID so multiple imports overwrite eachother - and a little watermark
            'uid'        => $this->_dungeonRoute->public_key . 'xxKG',
        ];

        try {
            return $this->encode($mdtObject);
        } catch (\Exception $exception) {
            // Encoding issue - adjust the title and try again
            if (str_contains($exception->getMessage(), "call to lua function [string &quot;line&quot;]")) {
                $asciiTitle = preg_replace('/[[:^print:]]/', '', $this->_dungeonRoute->title);

                // If stripping ascii characters worked in changing the title somehow
                if ($asciiTitle !== $this->_dungeonRoute->title) {
                    $warnings->push(
                        new ImportWarning(__('Title'),
                            __('Your route title contains non-ascii characters that are known to trigger a yet unresolved encoding bug in Keystone.guru. 
                                Your route title has been stripped of all offending characters, we apologise for the inconvenience and hope to resolve this issue soon.'),
                            ['details' => sprintf(__('Old title: %s, new title: %s'), $this->_dungeonRoute->title, $asciiTitle)]
                        )
                    );
                    $this->_dungeonRoute->title = $asciiTitle;

                    return $this->getEncodedString($warnings);
                } else {
                    $fixedMapIconComment = false;

                    foreach ($this->_dungeonRoute->mapicons as $mapicon) {
                        $asciiComment = preg_replace('/[[:^print:]]/', '', $mapicon->comment);
                        if ($asciiComment !== $mapicon->comment) {
                            $warnings->push(
                                new ImportWarning(__('Map icon'),
                                    __('One of your comments on a map icon has non-ascii characters that are known to trigger a yet unresolved encoding bug in Keystone.guru. 
                                Your map comment has been stripped of all offending characters, we apologise for the inconvenience and hope to resolve this issue soon.'),
                                    ['details' => sprintf(__('Old comment: "%s", new comment: "%s"'), $asciiComment, $mapicon->comment)]
                                )
                            );
                            $mapicon->comment = $asciiComment;

                            $fixedMapIconComment = true;
                        }
                    }

                    // If we fixed something, try again with encoding
                    if ($fixedMapIconComment) {
                        return $this->getEncodedString($warnings);
                    } else {
                        throw $exception;
                    }
                }
            } else {
                throw $exception;
            }
        }
    }

    /**
     * Sets a dungeon route to be staged for encoding to an encoded string.
     *
     * @param $dungeonRoute DungeonRoute
     * @return $this Returns self to allow for chaining.
     */
    public function setDungeonRoute(DungeonRoute $dungeonRoute): ExportString
    {
        $this->_dungeonRoute = $dungeonRoute->load(['affixgroups', 'dungeon']);

        return $this;
    }
}