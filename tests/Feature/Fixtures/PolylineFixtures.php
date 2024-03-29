<?php

namespace Tests\Feature\Fixtures;

use App\Logic\Structs\LatLng;
use App\Models\Floor\Floor;
use Illuminate\Support\Collection;
use Random\RandomException;

class PolylineFixtures
{
    /**
     * @param Collection<LatLng>|null $latLngs
     * @return array{color: string, color_animated: string, weight: int, vertices_json: string}
     * @throws RandomException
     */
    public static function createPolyline(
        Floor       $floor,
        ?Collection $latLngs = null,
        ?string     $color = null,
        ?string     $colorAnimated = null,
        ?int        $weight = null
    ): array {
        return [
            'color'          => $color ?? randomHexColor(),
            'color_animated' => $colorAnimated ?? randomHexColor(),
            'weight'         => $weight ?? random_int(1, 5),
            'vertices_json'  => json_encode($latLngs !== null ? $latLngs->toArray() : [
                LatLngFixtures::getLatLng($floor)->toArray(),
                LatLngFixtures::getLatLng($floor)->toArray(),
            ]),
        ];
    }
}
