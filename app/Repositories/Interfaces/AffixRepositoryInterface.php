<?php

namespace App\Repositories\Interfaces;

use App\Models\Affix;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @method Affix create(array $attributes)
 * @method Affix find(int $id, array $columns = [])
 * @method Affix findOrFail(int $id, array $columns = [])
 * @method Affix findOrNew(int $id, array $columns = [])
 * @method bool save(Affix $model)
 * @method bool update(Affix $model, array $attributes = [], array $options = [])
 * @method bool delete(Affix $model)
 * @method Collection<Affix> all()
 */
interface AffixRepositoryInterface extends BaseRepositoryInterface
{

}
