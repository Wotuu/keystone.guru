<?php

namespace App\Http\Models\Response\RouteThumbnailJob;

/**
 * @OA\Schema(schema="RouteThumbnailJobEnvelope")
 */
class RouteThumbnailJobEnvelopeResponseModel
{
    /**
     * @OA\Property(ref="#/components/schemas/RouteThumbnailJob")
     *
     * @var RouteThumbnailJobResponseModel
     */
    public RouteThumbnailJobResponseModel $data;
}
