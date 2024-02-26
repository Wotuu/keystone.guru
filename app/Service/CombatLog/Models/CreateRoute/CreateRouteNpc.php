<?php

namespace App\Service\CombatLog\Models\CreateRoute;

use App\Models\Enemy;
use Carbon\Carbon;

class CreateRouteNpc
{
    private Carbon $engagedAtCarbon;

    private Carbon $diedAtCarbon;

    private ?Enemy $resolvedEnemy = null;

    public function __construct(public int $npcId, public string $spawnUid, public string $engagedAt, public string $diedAt, public CreateRouteCoord $coord)
    {
    }

    public function getEngagedAt(): Carbon
    {
        return $this->engagedAtCarbon ??
            $this->engagedAtCarbon = Carbon::createFromFormat(CreateRouteBody::DATE_TIME_FORMAT, $this->engagedAt);
    }

    public function getDiedAt(): Carbon
    {
        return $this->diedAtCarbon ??
            $this->diedAtCarbon = Carbon::createFromFormat(CreateRouteBody::DATE_TIME_FORMAT, $this->diedAt);
    }

    public function getUniqueId(): string
    {
        return sprintf('%d-%s', $this->npcId, $this->spawnUid);
    }

    public function getResolvedEnemy(): ?Enemy
    {
        return $this->resolvedEnemy;
    }

    public function setResolvedEnemy(?Enemy $enemy): self
    {
        $this->resolvedEnemy = $enemy;

        return $this;
    }

    public static function createFromArray(array $body): CreateRouteNpc
    {
        return new CreateRouteNpc(
            $body['npcId'],
            $body['spawnUid'],
            $body['engagedAt'],
            $body['diedAt'],
            CreateRouteCoord::createFromArray($body['coord'])
        );
    }
}
