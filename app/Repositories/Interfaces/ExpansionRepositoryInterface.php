<?php

namespace App\Repositories\Interfaces;

use App\Models\Expansion;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @method Expansion create(array $attributes)
 * @method Expansion find(int $id, array $columns = [])
 * @method Expansion findOrFail(int $id, array $columns = [])
 * @method Expansion findOrNew(int $id, array $columns = [])
 * @method bool save(Expansion $model)
 * @method bool update(Expansion $model, array $attributes = [], array $options = [])
 * @method bool delete(Expansion $model)
 * @method Collection<Expansion> all()
 */
interface ExpansionRepositoryInterface extends BaseRepositoryInterface
{

}
