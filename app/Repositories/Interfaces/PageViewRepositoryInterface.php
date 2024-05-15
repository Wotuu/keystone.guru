<?php

namespace App\Repositories\Interfaces;

use App\Models\PageView;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @method PageView create(array $attributes)
 * @method PageView find(int $id, array $columns = [])
 * @method PageView findOrFail(int $id, array $columns = [])
 * @method PageView findOrNew(int $id, array $columns = [])
 * @method bool save(PageView $model)
 * @method bool update(PageView $model, array $attributes = [], array $options = [])
 * @method bool delete(PageView $model)
 * @method Collection<PageView> all()
 */
interface PageViewRepositoryInterface extends BaseRepositoryInterface
{

}
