<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class JsonStringCountRule implements Rule
{
    private int $count;

    /**
     * @param int $count
     */
    public function __construct(int $count)
    {
        $this->count = $count;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $decoded = json_decode($value, true);

        return is_array($decoded) && count($decoded) >= $this->count;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('rules.json_string_count_rule.message', ['count' => $this->count]);
    }
}
