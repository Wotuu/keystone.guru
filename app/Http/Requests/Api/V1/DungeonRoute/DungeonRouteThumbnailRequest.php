<?php

namespace App\Http\Requests\Api\V1\DungeonRoute;

use App\Http\Requests\Api\V1\APIFormRequest;
use Auth;
use Illuminate\Validation\Rule;

class DungeonRouteThumbnailRequest extends APIFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'width'      => 'nullable|int|min:192|max:1620',
            'height'     => 'nullable|int|min:128|max:1080',
            'zoom_level' => 'nullable|numeric|min:1|max:5',
            'quality'    => 'nullable|int|min:1|max:100',
        ];
    }
}
