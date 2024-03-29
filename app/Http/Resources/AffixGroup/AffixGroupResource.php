<?php

namespace App\Http\Resources\AffixGroup;

use App\Http\Resources\Affix\AffixCollectionResource;
use App\Models\AffixGroup\AffixGroup;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @mixin AffixGroup
 */
class AffixGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray(Request $request): array
    {
        return [
            'affixes' => new AffixCollectionResource($this->affixes),
        ];
    }
}
