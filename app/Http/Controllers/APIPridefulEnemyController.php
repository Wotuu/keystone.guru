<?php

namespace App\Http\Controllers;

use App\Events\ModelChangedEvent;
use App\Events\ModelDeletedEvent;
use App\Http\Controllers\Traits\PublicKeyDungeonRoute;
use App\Models\DungeonRoute;
use App\Models\Enemy;
use App\Models\PridefulEnemy;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Teapot\StatusCode\Http;

class APIPridefulEnemyController extends Controller
{
    use PublicKeyDungeonRoute;

    /**
     * @param Request $request
     * @param DungeonRoute $dungeonroute
     * @param Enemy $enemy
     * @return PridefulEnemy
     * @throws Exception
     */
    function store(Request $request, DungeonRoute $dungeonroute, Enemy $enemy)
    {
        if (!$dungeonroute->isTry()) {
            $this->authorize('edit', $dungeonroute);
        }

        /** @var PridefulEnemy $pridefulEnemy */
        $pridefulEnemy = PridefulEnemy::where('dungeon_route_id', $dungeonroute->id)->where('enemy_id', $enemy->id)->first();

        if ($pridefulEnemy === null) {
            $pridefulEnemy = new PridefulEnemy();
        }

        $pridefulEnemy->dungeon_route_id = $dungeonroute->id;
        $pridefulEnemy->enemy_id = (int)$enemy->id;
        $pridefulEnemy->floor_id = (int)$request->get('floor_id');
        $pridefulEnemy->lat = (float)$request->get('lat');
        $pridefulEnemy->lng = (float)$request->get('lng');

        if (!$pridefulEnemy->save()) {
            throw new Exception('Unable to save prideful enemy!');
        }

        if (Auth::check()) {
            broadcast(new ModelChangedEvent($pridefulEnemy->floor->dungeon, Auth::getUser(), $pridefulEnemy));
        }

        return $pridefulEnemy;
    }

    /**
     * @param Request $request
     * @param DungeonRoute $dungeonroute
     * @param Enemy $enemy
     * @return array|ResponseFactory|Response
     */
    function delete(Request $request, DungeonRoute $dungeonroute, Enemy $enemy)
    {
        try {
            /** @var PridefulEnemy $pridefulEnemy */
            $pridefulEnemy = PridefulEnemy::where('dungeon_route_id', $dungeonroute->id)->where('enemy_id', $enemy->id)->first();
            if ($pridefulEnemy->delete()) {
                if (Auth::check()) {
                    broadcast(new ModelDeletedEvent($pridefulEnemy->floor->dungeon, Auth::getUser(), $pridefulEnemy));
                }
            }
            $result = response()->noContent();
        } catch (Exception $ex) {
            $result = response('Not found', Http::NOT_FOUND);
        }

        return $result;
    }
}
