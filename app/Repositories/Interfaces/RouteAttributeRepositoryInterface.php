<?php

namespace App\Repositories\Interfaces;

use App\Models\RouteAttribute;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @method RouteAttribute create(array $attributes)
 * @method RouteAttribute find(int $id, array $columns = [])
 * @method RouteAttribute findOrFail(int $id, array $columns = [])
 * @method RouteAttribute findOrNew(int $id, array $columns = [])
 * @method bool save(RouteAttribute $model)
 * @method bool update(RouteAttribute $model, array $attributes = [], array $options = [])
 * @method bool delete(RouteAttribute $model)
 * @method Collection<RouteAttribute> all()
 */
interface RouteAttributeRepositoryInterface extends BaseRepositoryInterface
{

}
