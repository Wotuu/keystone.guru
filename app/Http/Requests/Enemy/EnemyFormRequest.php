<?php

namespace App\Http\Requests\Enemy;

use App\Models\Enemy;
use App\Models\EnemyPack;
use App\Models\Faction;
use App\Models\Floor;
use App\Models\Mapping\MappingVersion;
use App\Models\Npc;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnemyFormRequest extends FormRequest
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
            'id'                            => 'int',
            'mapping_version_id'            => Rule::exists(MappingVersion::class, 'id'),
            'floor_id'                      => Rule::exists(Floor::class, 'id'),
            'enemy_pack_id'                 => ['nullable', Rule::exists(EnemyPack::class, 'id')],
            'npc_id'                        => ['nullable', Rule::exists(Npc::class, 'id')],
            'mdt_id'                        => 'nullable|int',
            'mdt_npc_id'                    => 'nullable|int',
            'seasonal_index'                => 'nullable|int',
            'seasonal_type'                 => [Rule::in(array_merge(array_keys(Enemy::SEASONAL_TYPE_ALL), ['', null]))],
            'teeming'                       => [Rule::in(array_merge(array_keys(Enemy::TEEMING_ALL), ['', null]))],
            'faction'                       => [Rule::in(array_merge(array_keys(Faction::ALL), ['any']))],
            'required'                      => 'boolean',
            'skippable'                     => 'boolean',
            'enemy_forces_override'         => 'int',
            'enemy_forces_override_teeming' => 'int',
            'lat'                           => 'numeric',
            'lng'                           => 'numeric',
        ];
    }
}
