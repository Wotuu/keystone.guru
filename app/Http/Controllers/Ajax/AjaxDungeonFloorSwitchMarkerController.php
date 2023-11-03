<?php

namespace App\Http\Controllers\Ajax;

use App\Events\Model\ModelDeletedEvent;
use App\Http\Controllers\Traits\ListsDungeonFloorSwitchMarkers;
use App\Http\Requests\DungeonFloorSwitchMarker\DungeonFloorSwitchMarkerFormRequest;
use App\Models\DungeonFloorSwitchMarker;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Teapot\StatusCode\Http;
use Throwable;

class AjaxDungeonFloorSwitchMarkerController extends AjaxMappingModelBaseController
{
    use ListsDungeonFloorSwitchMarkers;

    public function list(Request $request)
    {
        return $this->listDungeonFloorSwitchMarkers($request->get('floor_id'));
    }

    /**
     * @param DungeonFloorSwitchMarkerFormRequest $request
     * @param DungeonFloorSwitchMarker|null       $dungeonFloorSwitchMarker
     * @return DungeonFloorSwitchMarker|Model
     * @throws Throwable
     */
    public function store(DungeonFloorSwitchMarkerFormRequest $request, DungeonFloorSwitchMarker $dungeonFloorSwitchMarker = null): DungeonFloorSwitchMarker
    {
        $validated = $request->validated();

        if ((int)$validated['source_floor_id'] === -1) {
            $validated['source_floor_id'] = null;
        }

        if ((int)$validated['direction'] === -1) {
            $validated['direction'] = null;
        }

        return $this->storeModel($validated, DungeonFloorSwitchMarker::class, $dungeonFloorSwitchMarker);
    }

    /**
     * @param Request                  $request
     * @param DungeonFloorSwitchMarker $dungeonFloorSwitchMarker
     * @return ResponseFactory|Response
     */
    public function delete(Request $request, DungeonFloorSwitchMarker $dungeonFloorSwitchMarker)
    {
        try {
            $dungeon = $dungeonFloorSwitchMarker->floor->dungeon;
            if ($dungeonFloorSwitchMarker->delete()) {
                if (Auth::check()) {
                    broadcast(new ModelDeletedEvent($dungeon, Auth::getUser(), $dungeonFloorSwitchMarker));
                }

                // Trigger mapping changed event so the mapping gets saved across all environments
                $this->mappingChanged($dungeonFloorSwitchMarker, null);
            }
            $result = response()->noContent();
        } catch (Exception $ex) {
            $result = response('Not found', Http::NOT_FOUND);
        }

        return $result;
    }
}
