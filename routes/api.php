<?php

use App\Http\Controllers\Api\V1\Combatlog\APICombatLogController;
use App\Http\Controllers\Api\V1\Dungeon\APIDungeonController;
use App\Http\Controllers\Api\V1\RaiderIO\APIRaiderIOController;
use App\Http\Controllers\Api\V1\Route\APIDungeonRouteController;
use App\Http\Controllers\Api\V1\Route\APIDungeonRouteThumbnailJobController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(static function () {
    Route::prefix('combatlog')->group(static function () {
        Route::post('route', (new APICombatLogController())->createRoute(...))->name('api.v1.combatlog.route.create');
        Route::post('event', (new APICombatLogController())->createEvent(...))->name('api.v1.combatlog.event.create');
    });

    Route::prefix('route')->group(static function () {
        Route::get('/', (new APIDungeonRouteController())->get(...))->name('api.v1.route.list');
        Route::post('/{dungeonRoute}/thumbnail', (new APIDungeonRouteController())->createThumbnails(...))->name('api.v1.route.thumbnail.create');
        Route::get('/thumbnailJob/{dungeonRouteThumbnailJob}', (new APIDungeonRouteThumbnailJobController())->get(...))->name('api.v1.thumbnailjob.get');
    });

    Route::prefix('raiderio')->group(static function () {
        Route::post('/heatmapdata', (new APIRaiderIOController())->getHeatmapData(...))->name('api.v1.raiderio.heatmapdata.get');
    });

    // Static data
    Route::prefix('dungeon')->group(static function () {
        Route::get('/', (new APIDungeonController())->get(...))->name('api.v1.combatlog.dungeon.list');
    });
});
