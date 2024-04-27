<?php

namespace App\Service\CombatLogEvent;

use App\Models\CombatLog\CombatLogEvent;
use App\Service\CombatLogEvent\Logging\CombatLogEventServiceLoggingInterface;
use App\Service\CombatLogEvent\Models\CombatLogEventFilter;
use App\Service\CombatLogEvent\Models\CombatLogEventGridAggregationResult;
use App\Service\CombatLogEvent\Models\CombatLogEventSearchResult;
use App\Service\Coordinates\CoordinatesServiceInterface;
use Codeart\OpensearchLaravel\Aggregations\Aggregation;
use Codeart\OpensearchLaravel\Aggregations\Types\Cardinality;
use Codeart\OpensearchLaravel\Aggregations\Types\ScriptedMetric;
use Codeart\OpensearchLaravel\Search\SearchQueries\Types\MatchOne;

class CombatLogEventService implements CombatLogEventServiceInterface
{
    public function __construct(
        private readonly CoordinatesServiceInterface           $coordinatesService,
        private readonly CombatLogEventServiceLoggingInterface $log
    ) {
    }

    /**
     * @return CombatLogEventSearchResult
     */
    public function getCombatLogEvents(CombatLogEventFilter $filters): CombatLogEventSearchResult
    {
        $combatLogEvents = collect();

        try {
            $this->log->getCombatLogEventsStart($filters->toArray());

            $combatLogEvents = CombatLogEvent::opensearch()
                ->builder()
                ->search($filters->toOpensearchQuery())
                ->get();

            $combatLogEvents = CombatLogEvent::openSearchResultToModels($combatLogEvents);
        } catch (\Exception $e) {
            $this->log->getCombatLogEventsException($e);
        } finally {
            $this->log->getCombatLogEventsEnd();
        }

        return new CombatLogEventSearchResult($this->coordinatesService, $filters, $combatLogEvents, 10);
    }

    public function getGridAggregation(CombatLogEventFilter $filters): ?CombatLogEventGridAggregationResult
    {
        $result = null;

        try {
            $this->log->getGeotileGridAggregationStart($filters->toArray());

            $gridResult = [];

            // Repeat this query for each floor
            foreach ($filters->getDungeon()->floors()->where('facade', false)->get() as $floor) {
                $filterQuery = $filters->toOpensearchQuery([
                    MatchOne::make('ui_map_id', $floor->ui_map_id),
                ]);


//                dd(json_encode(CombatLogEvent::opensearch()
//                    ->builder()
//                    ->search($filterQuery)
//                    ->toArray()));

                $searchResult = CombatLogEvent::opensearch()
                    ->builder()
                    ->search($filterQuery)
                    ->aggregations([
                        Aggregation::make(
                            name: "heatmap",
                            aggregationType: ScriptedMetric::make(
                                mapScript: strtr('
                                   int sizeX = :sizeX;
                                   int sizeY = :sizeY;

                                   float minX = :minXf;
                                   float minY = :minYf;
                                   float maxX = :maxXf;
                                   float maxY = :maxYf;

                                   float width = maxX - minX;
                                   float height = maxY - minY;
                                   float stepX = width / sizeX;
                                   float stepY = height / sizeY;

                                   int gx = ((doc[\'pos_x\'].value - minX) / width * sizeX).intValue();
                                   int gy = ((doc[\'pos_y\'].value - minY) / height * sizeY).intValue();
                                   String key = ((gx * stepX) + minX).toString() + \',\' + ((gy * stepY) + minY).toString();
                                   if (state.map.containsKey(key)) {
                                     state.map[key] += 1;
                                   } else {
                                     state.map[key] = 1;
                                   }
                                 ', [
                                    ':sizeX' => config('keystoneguru.heatmap.service.data.sizeX'),
                                    ':sizeY' => config('keystoneguru.heatmap.service.data.sizeY'),
                                    ':minX'  => $floor->ingame_min_x,
                                    ':minY'  => $floor->ingame_min_y,
                                    ':maxX'  => $floor->ingame_max_x,
                                    ':maxY'  => $floor->ingame_max_y,
                                ]),
                                combineScript: 'return state.map',
                                reduceScript: '
                                   Map result = [:];
                                   for (state in states) {
                                     for (entry in state.entrySet()) {
                                       if (result.containsKey(entry.getKey())) {
                                         result[entry.getKey()] += entry.getValue();
                                       } else {
                                         result[entry.getKey()] = entry.getValue();
                                       }
                                     }
                                   }
                                   return result;
                                 ',
                                initScript: 'state.map = [:]'
                            )
                        ),
                    ])
                    ->size(0)
                    ->get();

                $gridResult[$floor->id] = $searchResult['aggregations']['heatmap']['value'];
            }

            // Request the amount of affected runs
            $runCountSearchResult = CombatLogEvent::opensearch()
                ->builder()
                ->search($filters->toOpensearchQuery())
                ->aggregations([
                    Aggregation::make(
                        name: "run_count",
                        aggregationType: Cardinality::make('run_id')
                    ),
                ])
                ->size(0)
                ->get();

            $result = new CombatLogEventGridAggregationResult(
                $this->coordinatesService,
                $filters,
                $gridResult,
                $runCountSearchResult['aggregations']['run_count']['value']
            );
        } catch (\Exception $e) {
            $this->log->getGeotileGridAggregationException($e);
        } finally {
            $this->log->getGeotileGridAggregationEnd();
        }

        return $result;
    }
}
