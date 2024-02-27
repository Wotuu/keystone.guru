<?php

namespace App\Rules;

use App\Service\CombatLog\Models\CreateRoute\CreateRouteBody;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateRouteNpcChronologicalRule implements ValidationRule
{
    /** @var array|int[] */
    private array $failedNpcIndices = [];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $index => $npc) {
            $engagedAt = $npc['engagedAt'] ?? null;
            $diedAt    = $npc['diedAt'] ?? null;

            if ($engagedAt === null || $diedAt === null) {
                $this->failedNpcIndices[] = $index;

                continue;
            }

            $engagedAtCarbon = Carbon::createFromFormat(CreateRouteBody::DATE_TIME_FORMAT, $engagedAt);
            $diedAtCarbon    = Carbon::createFromFormat(CreateRouteBody::DATE_TIME_FORMAT, $diedAt);

            if ($diedAtCarbon->isBefore($engagedAtCarbon)) {
                $this->failedNpcIndices[] = $index;
            }
        }

        if (!empty($this->failedNpcIndices)) {
            $fail(__('rules.create_route_npc_chronological_rule.message', ['npcs' => implode(', ', $this->failedNpcIndices)]));
        }
    }
}
