<?php

/** @noinspection PhpVoidFunctionResultUsedInspection */

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\Metric\APIDungeonRouteMetricFormRequest;
use App\Http\Requests\Metric\APIMetricFormRequest;
use App\Models\DungeonRoute\DungeonRoute;
use App\Service\Metric\MetricServiceInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

class AjaxMetricController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(APIMetricFormRequest $request, MetricServiceInterface $metricService): Response
    {
        $validated = $request->validated();

        $metricService->storeMetric($request['model_id'], $request['model_class'], $validated['category'], $validated['tag'], $validated['value']);

        return response()->noContent();
    }

    public function storeDungeonRoute(APIDungeonRouteMetricFormRequest $request, DungeonRoute $dungeonRoute, MetricServiceInterface $metricService): Response
    {
        $validated = $request->validated();

        $metricService->storeMetricByModel($dungeonRoute, $validated['category'], $validated['tag'], $validated['value']);

        return response()->noContent();
    }
}
