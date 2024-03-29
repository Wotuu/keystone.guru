<?php

namespace App\Logic\CombatLog\SpecialEvents;

/**
 * ENCHANT_REMOVED,0000000000000000,nil,0x80000000,0x80000000,Player-3684-0DE448BF,"Bunten-Mal'Ganis",0x511,0x0,"Howling Rune",204319,"Bloodfire Extraction Conduit"
 * ENCHANT_APPLIED,Player-3684-0DE448BF,"Bunten-Mal'Ganis",0x511,0x8,Player-3684-0DE448BF,"Bunten-Mal'Ganis",0x511,0x8,"Howling Rune",195505,"Caustic Coldsteel Slicer"
 *
 * @author Wouter
 *
 * @since 26/05/2023
 */
abstract class EnchantBase extends SpecialEvent
{
    private string $spellName;

    private int $itemId;

    private string $itemName;

    public function getSpellName(): string
    {
        return $this->spellName;
    }

    public function getItemId(): int
    {
        return $this->itemId;
    }

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function setParameters(array $parameters): self
    {
        parent::setParameters($parameters);

        $this->spellName = $parameters[0];
        $this->itemId    = (int)$parameters[1];
        $this->itemName  = $parameters[2];

        return $this;
    }

    public function getParameterCount(): int
    {
        return 11;
    }
}
