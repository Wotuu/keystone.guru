<?php

namespace App\Repositories\Database;

use App\Models\Npc;
use App\Repositories\Database\DatabaseRepository;
use App\Repositories\Interfaces\NpcRepositoryInterface;

class NpcRepository extends DatabaseRepository implements NpcRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Npc::class);
    }
}
