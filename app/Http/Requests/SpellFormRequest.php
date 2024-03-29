<?php

namespace App\Http\Requests;

use App\Models\Spell;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpellFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'id'          => 'required',
            'name'        => 'required|string',
            'icon_name'   => 'required|string',
            'dispel_type' => Rule::in(Spell::ALL_DISPEL_TYPES),
            'schools'     => 'array',
            'schools.*'   => Rule::in(Spell::ALL_SCHOOLS),
            'aura'        => 'boolean',
        ];

        return $rules;
    }
}
