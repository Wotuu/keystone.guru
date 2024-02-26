<?php

namespace App\Logic\SimulationCraft;

use App\Models\Enemy;
use App\Models\Npc;
use App\Models\NpcClassification;
use App\Models\SimulationCraft\SimulationCraftRaidEventsOptions;
use Illuminate\Support\Str;

class RaidEventPullEnemy implements RaidEventPullEnemyInterface, RaidEventOutputInterface
{
    public function __construct(private readonly SimulationCraftRaidEventsOptions $options, private readonly Enemy $enemy, private readonly int $enemyIndexInPull)
    {
    }

    /**
     * @param SimulationCraftRaidEventsOptions $options
     * @param Npc                              $npc
     * @return int
     */
    public function calculateHealth(SimulationCraftRaidEventsOptions $options, Npc $npc): int
    {
        return $npc->calculateHealthForKey(
                $options->key_level,
                $options->affix === SimulationCraftRaidEventsOptions::AFFIX_FORTIFIED,
                $options->affix === SimulationCraftRaidEventsOptions::AFFIX_TYRANNICAL,
                $options->isThunderingAffixActive()
            ) * ($this->options->hp_percent / 100);
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        $name = sprintf('%s_%s', Str::slug($this->enemy->npc->name), $this->enemyIndexInPull);

        if ($this->enemy->seasonal_type === Enemy::SEASONAL_TYPE_SHROUDED) {
            $name = sprintf('BOUNTY1_%s', $name);
        } else if ($this->enemy->seasonal_type === Enemy::SEASONAL_TYPE_SHROUDED_ZUL_GAMUX) {
            $name = sprintf('BOUNTY3_%s', $name);
        } else if ($this->enemy->npc->classification_id === NpcClassification::ALL[NpcClassification::NPC_CLASSIFICATION_BOSS]) {
            $name = sprintf('BOSS_%s', $name);
        }

        $health = $this->calculateHealth($this->options, $this->enemy->npc);

        return sprintf('"%s":%d', $name, $health);
    }
}
