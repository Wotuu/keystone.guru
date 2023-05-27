<?php

namespace App\Logic\CombatLog\Guid;

abstract class Guid
{
    private const GUID_TYPE_BATTLE_PET    = 'BattlePet';
    private const GUID_TYPE_B_NET_ACCOUNT = 'BNetAccount';
    private const GUID_TYPE_CAST          = 'Cast';
    private const GUID_TYPE_CLIENT_ACTOR  = 'ClientActor';
    private const GUID_TYPE_CREATURE      = 'Creature';
    private const GUID_TYPE_FOLLOWER      = 'Follower';
    private const GUID_TYPE_ITEM          = 'Item';
    private const GUID_TYPE_PLAYER        = 'Player';
    private const GUID_TYPE_VIGNETTE      = 'Vignette';

    private const GUID_TYPE_CLASS_MAPPING = [
        self::GUID_TYPE_BATTLE_PET    => BattlePet::class,
        self::GUID_TYPE_B_NET_ACCOUNT => BNetAccount::class,
        self::GUID_TYPE_CAST          => Cast::class,
        self::GUID_TYPE_CLIENT_ACTOR  => ClientActor::class,
        self::GUID_TYPE_CREATURE      => Creature::class,
        self::GUID_TYPE_FOLLOWER      => Follower::class,
        self::GUID_TYPE_ITEM          => Item::class,
        self::GUID_TYPE_PLAYER        => Player::class,
        self::GUID_TYPE_VIGNETTE      => Vignette::class,
    ];

    private string $guid;

    protected function __construct(string $guid)
    {
        $this->guid = $guid;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @param string $guid
     * @return Guid|null
     */
    public static function createFromGuidString(string $guid): ?Guid
    {
        if ($guid === '0000000000000000') {
            return null;
        }

        $result = null;

        $parameters = explode('-', $guid);
        $guidType   = array_shift($parameters);

        foreach (self::GUID_TYPE_CLASS_MAPPING as $guidTypeCandidate => $className) {
            if ($guidType === $guidTypeCandidate) {
                $result = new $className($guid, $parameters);
                break;
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->guid;
    }
}
