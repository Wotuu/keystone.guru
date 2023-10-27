<?php

namespace App\Http\Controllers\Ajax;

use App\Events\Model\ModelDeletedEvent;
use App\Http\Controllers\Traits\PublicKeyDungeonRoute;
use App\Http\Requests\Enemy\APIEnemyFormRequest;
use App\Models\DungeonRoute;
use App\Models\DungeonRouteEnemyRaidMarker;
use App\Models\Enemy;
use App\Models\EnemyActiveAura;
use App\Models\RaidMarker;
use App\Models\Spell;
use App\Service\Coordinates\CoordinatesServiceInterface;
use DB;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Teapot\StatusCode\Http;
use Throwable;

class AjaxEnemyController extends AjaxMappingModelBaseController
{
    use PublicKeyDungeonRoute;

    /**
     * @param APIEnemyFormRequest         $request
     * @param CoordinatesServiceInterface $coordinatesService
     * @param Enemy|null                  $enemy
     *
     * @return Enemy|Model
     * @throws Throwable
     */
    public function store(
        APIEnemyFormRequest         $request,
        CoordinatesServiceInterface $coordinatesService,
        Enemy                       $enemy = null
    ): Enemy {
        $validated = $request->validated();

        $validated['vertices_json'] = json_encode($request->get('vertices'));
        unset($validated['vertices']);

        $previousFloor = null;
        if ($enemy !== null) {
            // Load the enemy from database - don't use the given enemy's floor since that'll be the new floor potentially
            /** @var Enemy|null $previousEnemy */
            $previousEnemy = optional(Enemy::with(['floor'])->find($enemy->id));
            $previousFloor = $previousEnemy->floor;
        }

        return $this->storeModel($validated, Enemy::class, $enemy, function (Enemy $enemy) use ($request, $coordinatesService, $previousFloor) {
            $activeAuras = $request->get('active_auras', []);

            // Clear current active auras
            $enemy->enemyActiveAuras()->delete();
            foreach ($activeAuras as $activeAura) {
                if (!empty($activeAura)) {
                    $spell = Spell::findOrFail($activeAura);
                    // Only when the passed spell is actually an aura
                    if ($spell->aura) {
                        EnemyActiveAura::insert([
                            'enemy_id' => $enemy->id,
                            'spell_id' => $activeAura,
                        ]);
                    }
                }
            }

            $enemy->load(['npc', 'npc.enemyForces', 'floor'])->makeHidden(['floor']);

            // Perform floor change and move enemy to the correct location on the new floor
            if ($previousFloor !== null && $enemy->floor->id !== $previousFloor->id) {
                $ingameXY  = $coordinatesService->calculateIngameLocationForMapLocation($enemy->getLatLng()->setFloor($previousFloor));
                $newLatLng = $coordinatesService->calculateMapLocationForIngameLocation($ingameXY->setFloor($enemy->floor));

                $enemy->update($newLatLng->toArray());
            }
        });
    }

    /**
     * @param Request      $request
     * @param DungeonRoute $dungeonRoute
     * @param Enemy        $enemy
     *
     * @return array|ResponseFactory|Response
     * @throws AuthorizationException
     */
    public function setRaidMarker(Request $request, DungeonRoute $dungeonRoute, Enemy $enemy)
    {
        $this->authorize('edit', $dungeonRoute);

        try {
            $raidMarkerName = $request->get('raid_marker_name', '');

            // Delete existing enemy raid marker
            DungeonRouteEnemyRaidMarker::where('enemy_id', $enemy->id)->where('dungeon_route_id', $dungeonRoute->id)->delete();

            // Create a new one, if the user didn't just want to clear it
            if (!empty($raidMarkerName)) {
                DungeonRouteEnemyRaidMarker::create([
                    'dungeon_route_id' => $dungeonRoute->id,
                    'raid_marker_id'   => RaidMarker::ALL[$raidMarkerName],
                    'enemy_id'         => $enemy->id,
                ]);

                $result = ['name' => $raidMarkerName];
            } else {
                $result = ['name' => ''];
            }

        } catch (Exception $ex) {
            $result = response('Not found', Http::NOT_FOUND);
        }

        return $result;
    }

    /**
     * @param Request $request
     * @param Enemy   $enemy
     *
     * @return Response|ResponseFactory
     * @throws Throwable
     */
    public function delete(Request $request, Enemy $enemy)
    {
        return DB::transaction(function () use ($request, $enemy) {
            try {
                if ($enemy->delete()) {
                    // Trigger mapping changed event so the mapping gets saved across all environments
                    $this->mappingChanged($enemy, null);

                    if (Auth::check()) {
                        broadcast(new ModelDeletedEvent($enemy->floor->dungeon, Auth::getUser(), $enemy));
                    }
                }
                $result = response()->noContent();
            } catch (Exception $ex) {
                $result = response('Not found', Http::NOT_FOUND);
            }

            return $result;
        });
    }
}
