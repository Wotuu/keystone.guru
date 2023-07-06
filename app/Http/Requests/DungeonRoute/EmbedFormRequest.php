<?php

namespace App\Http\Requests\DungeonRoute;

use Illuminate\Foundation\Http\FormRequest;

class EmbedFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pulls'             => 'nullable|bool',
            'pullsDefaultState' => 'nullable|bool',
            'pullsHideOnMove'   => 'nullable|bool',
            'enemyinfo'         => 'nullable|bool',
        ];
    }

    public function messages()
    {
        return array_merge(parent::messages(), [
            'pullsDefaultState.in' => 'sidebarDefaultState must be one of "hidden" or "shown"',
        ]);
    }
}
