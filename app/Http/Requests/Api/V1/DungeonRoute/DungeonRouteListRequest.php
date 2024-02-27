<?php

namespace App\Http\Requests\Api\V1\DungeonRoute;

use App\Http\Requests\Api\V1\APIFormRequest;
use Illuminate\Validation\Rule;

class DungeonRouteListRequest extends APIFormRequest
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
            'dungeon_id' => ['nullable', Rule::exists('dungeons', 'id')],
        ];
    }
}
