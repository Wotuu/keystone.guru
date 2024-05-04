<?php

namespace App\Repositories\Stub\DungeonRoute;

use App\Models\DungeonRoute\DungeonRoute;
use App\Repositories\Interfaces\DungeonRoute\DungeonRouteRepositoryInterface;
use App\Repositories\Stub\StubRepository;

class DungeonRouteRepository extends StubRepository implements DungeonRouteRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(DungeonRoute::class);
    }
}
