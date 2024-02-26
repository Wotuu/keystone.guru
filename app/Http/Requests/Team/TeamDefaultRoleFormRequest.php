<?php

namespace App\Http\Requests\Team;

use App\Models\TeamUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * User wants to change the default role of the team
 */
class TeamDefaultRoleFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'default_role' => ['required', Rule::in(array_keys(TeamUser::ALL_ROLES))],
        ];
    }
}
