<?php

namespace App\Models;

use App\Models\Mapping\MappingModelInterface;
use App\Models\Mapping\MappingVersion;
use App\Models\Npc\NpcEnemyForces;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int                                 $id
 * @property int                                 $dungeon_id
 * @property int                                 $classification_id
 * @property int                                 $npc_type_id
 * @property int                                 $npc_class_id
 * @property int                                 $display_id
 * @property string                              $name
 * @property int                                 $base_health
 * @property int|null                            $health_percentage Null = 100% health
 * @property string                              $aggressiveness
 * @property bool                                $dangerous
 * @property bool                                $truesight
 * @property bool                                $bursting
 * @property bool                                $bolstering
 * @property bool                                $sanguine
 * @property bool                                $runs_away_in_fear
 * @property bool                                $hyper_respawn
 *
 * @property Dungeon                             $dungeon
 * @property NpcClassification                   $classification
 * @property NpcType                             $type
 * @property NpcClass                            $class
 * @property NpcEnemyForces|null                 $enemyForces
 *
 * @property NpcEnemyForces[]|Collection         $npcEnemyForces
 * @property Enemy[]|Collection                  $enemies
 * @property NpcBolsteringWhitelist[]|Collection $npcbolsteringwhitelists
 *
 * @mixin Eloquent
 */
class Npc extends CacheModel implements MappingModelInterface
{
    public $incrementing = false;
    public $timestamps   = false;

    protected $with     = ['type', 'class', 'npcbolsteringwhitelists', 'spells'];
    protected $fillable = [
        'id',
        'dungeon_id',
        'classification_id',
        'npc_type_id',
        'npc_class_id',
        'display_id',
        'name',
        'base_health',
        'health_percentage',
        'aggressiveness',
        'dangerous',
        'truesight',
        'bursting',
        'bolstering',
        'sanguine',
        'runs_away_in_fear',
    ];

    public const AGGRESSIVENESS_AGGRESSIVE = 'aggressive';
    public const AGGRESSIVENESS_UNFRIENDLY = 'unfriendly';
    public const AGGRESSIVENESS_NEUTRAL    = 'neutral';
    public const AGGRESSIVENESS_FRIENDLY   = 'friendly';
    public const AGGRESSIVENESS_AWAKENED   = 'awakened';

    public const ALL_AGGRESSIVENESS = [
        self::AGGRESSIVENESS_AGGRESSIVE,
        self::AGGRESSIVENESS_UNFRIENDLY,
        self::AGGRESSIVENESS_NEUTRAL,
        self::AGGRESSIVENESS_FRIENDLY,
        self::AGGRESSIVENESS_AWAKENED,
    ];

    /**
     * Gets all derived enemies from this Npc.
     *
     * @return hasMany
     */
    public function enemies(): HasMany
    {
        return $this->hasMany(Enemy::class);
    }

    /**
     * @return hasMany
     */
    public function npcbolsteringwhitelists(): HasMany
    {
        return $this->hasMany(NpcBolsteringWhitelist::class);
    }

    /**
     * @return belongsTo
     */
    public function dungeon(): BelongsTo
    {
        return $this->belongsTo(Dungeon::class);
    }

    /**
     * @return belongsTo
     */
    public function classification(): BelongsTo
    {
        return $this->belongsTo(NpcClassification::class);
    }

    /**
     * @return belongsTo
     */
    public function type(): BelongsTo
    {
        // Not sure why the foreign key declaration is required here, but it is
        return $this->belongsTo(NpcType::class, 'npc_type_id');
    }

    /**
     * @return belongsTo
     */
    public function class(): BelongsTo
    {
        // Not sure why the foreign key declaration is required here, but it is
        return $this->belongsTo(NpcClass::class, 'npc_class_id');
    }

    /**
     * @return BelongsToMany
     */
    public function spells(): BelongsToMany
    {
        return $this->belongsToMany(Spell::class, 'npc_spells');
    }

    /**
     * @return HasMany
     */
    public function npcspells(): HasMany
    {
        return $this->hasMany(NpcSpell::class);
    }

    /**
     * @return HasMany
     */
    public function npcEnemyForces(): HasMany
    {
        return $this->hasMany(NpcEnemyForces::class)->orderByDesc('mapping_version_id');
    }

    /**
     * @return HasOne
     */
    public function enemyForces(): HasOne
    {
        return $this->hasOne(NpcEnemyForces::class)->orderByDesc('mapping_version_id');
    }

    /**
     * @param int                 $enemyForces
     * @param MappingVersion|null $mappingVersion
     * @return NpcEnemyForces
     */
    public function setEnemyForces(int $enemyForces, ?MappingVersion $mappingVersion = null): NpcEnemyForces
    {
        if ($this->dungeon_id === -1 && $mappingVersion === null) {
            throw new \InvalidArgumentException('Unable to set enemy forces for global npc without a mapping version!');
        }

        $npcEnemyForces = $this->enemyForcesByMappingVersion($mappingVersion)->first();

        if ($npcEnemyForces === null) {
            $npcEnemyForces = NpcEnemyForces::create([
                'mapping_version_id'   => ($mappingVersion ?? $this->dungeon->getCurrentMappingVersion())->id,
                'npc_id'               => $this->id,
                'enemy_forces'         => $enemyForces,
            ]);
        } else {
            $npcEnemyForces->update([
                'enemy_forces'         => $enemyForces,
            ]);
        }

        return $npcEnemyForces;
    }

    /**
     * @param int|null $mappingVersionId
     * @return HasOne
     */
    public function enemyForcesByMappingVersion(?int $mappingVersionId = null): HasOne
    {
        $belongsTo = $this->hasOne(NpcEnemyForces::class);

        // Most recent
        if ($mappingVersionId === null) {
            $belongsTo->orderByDesc('mapping_version_id')->limit(1);
        } else {
            $belongsTo->where('mapping_version_id', $mappingVersionId);
        }

        return $belongsTo;
    }

    /**
     * @return bool
     */
    public function isEmissary(): bool
    {
        return in_array($this->id, [155432, 155433, 155434]);
    }

    /**
     * @return bool
     */
    public function isAwakened(): bool
    {
        return in_array($this->id, [161244, 161243, 161124, 161241]);
    }

    /**
     * @return bool
     */
    public function isEncrypted(): bool
    {
        return in_array($this->id, [185680, 185683, 185685]);
    }

    /**
     * @return bool
     */
    public function isPrideful(): bool
    {
        return $this->id === config('keystoneguru.prideful.npc_id');
    }

    /**
     * @return bool
     */
    public function isShrouded(): bool
    {
        return $this->id === config('keystoneguru.shrouded.npc_id');
    }

    /**
     * @return bool
     */
    public function isShroudedZulGamux(): bool
    {
        return $this->id === config('keystoneguru.shrouded.npc_id_zul_gamux');
    }

    /**
     * @return bool
     */
    public function isAffectedByFortified(): bool
    {
        return in_array($this->classification_id, [NpcClassification::ALL[NpcClassification::NPC_CLASSIFICATION_NORMAL], NpcClassification::ALL[NpcClassification::NPC_CLASSIFICATION_ELITE]]);
    }

    /**
     * @return bool
     */
    public function isAffectedByTyrannical(): bool
    {
        return in_array($this->classification_id, [NpcClassification::ALL[NpcClassification::NPC_CLASSIFICATION_BOSS], NpcClassification::ALL[NpcClassification::NPC_CLASSIFICATION_FINAL_BOSS]]);
    }

    /**
     * @param int  $keyLevel
     * @param bool $fortified
     * @param bool $tyrannical
     * @param bool $thundering
     * @return float
     */
    public function getScalingFactor(int $keyLevel, bool $fortified, bool $tyrannical, bool $thundering): float
    {
        $keyLevelFactor = 1;
        // 2 because we start counting up at key level 3 (+2 = 0)
        for ($i = 2; $i < $keyLevel; $i++) {
            $keyLevelFactor *= ($i < 10 ? config('keystoneguru.keystone.scaling_factor') : config('keystoneguru.keystone.scaling_factor_past_10'));
        }

        if ($fortified && $this->isAffectedByFortified()) {
            $keyLevelFactor *= 1.2;
        } else if ($tyrannical && $this->isAffectedByTyrannical()) {
            $keyLevelFactor *= 1.3;
        }

        if ($thundering) {
            $keyLevelFactor *= 1.05;
        }

        return round($keyLevelFactor * 100) / 100;
    }

    /**
     * @param int  $keyLevel
     * @param bool $fortified
     * @param bool $tyrannical
     * @param bool $thundering
     * @return void
     */
    public function calculateHealthForKey(int $keyLevel, bool $fortified, bool $tyrannical, bool $thundering): float
    {
        $thundering = $thundering && $keyLevel >= 10;

        return round($this->base_health * (($this->health_percentage ?? 100) / 100) * $this->getScalingFactor($keyLevel, $fortified, $tyrannical, $thundering));
    }

    /**
     * Upon creation of a new NPC, we must create npc enemy forces for each mapping version
     * @param int|null $existingEnemyForces
     * @return  bool
     */
    public function createNpcEnemyForcesForExistingMappingVersions(?int $existingEnemyForces = null): bool
    {
        $result = true;

        $this->load('dungeon');
        // Create new enemy forces for this enemy for each relevant mapping version
        // If no dungeon is found (dungeon_id = -1) we grab all mapping versions instead
        $mappingVersions = optional($this->dungeon)->mappingVersions ?? MappingVersion::all();
        foreach ($mappingVersions as $mappingVersion) {
            $result = $result && NpcEnemyForces::create([
                    'npc_id'               => $this->id,
                    'mapping_version_id'   => $mappingVersion->id,
                    'enemy_forces'         => $existingEnemyForces ?? 0,
                    'enemy_forces_teeming' => null,
                ]);
        }

        return $result;
    }


    public static function boot()
    {
        parent::boot();

        // Delete Npc properly if it gets deleted
        static::deleting(function (Npc $npc) {
            $npc->npcbolsteringwhitelists()->delete();
            $npc->npcspells()->delete();
            $npc->npcEnemyForces()->delete();
        });
    }

    /**
     * @return int|null
     */
    public function getDungeonId(): ?int
    {
        return $this->dungeon_id ?? null;
    }
}
