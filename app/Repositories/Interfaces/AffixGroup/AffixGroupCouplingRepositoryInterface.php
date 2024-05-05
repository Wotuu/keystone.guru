<?php

namespace App\Repositories\Interfaces\AffixGroup;

use App\Models\AffixGroup\AffixGroupCoupling;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @method AffixGroupCoupling create(array $attributes)
 * @method AffixGroupCoupling find(int $id, array $columns = [])
 * @method AffixGroupCoupling findOrFail(int $id, array $columns = [])
 * @method AffixGroupCoupling findOrNew(int $id, array $columns = [])
 * @method bool save(AffixGroupCoupling $model)
 * @method bool update(AffixGroupCoupling $model, array $attributes = [], array $options = [])
 * @method bool delete(AffixGroupCoupling $model)
 * @method Collection<AffixGroupCoupling> all()
 */
interface AffixGroupCouplingRepositoryInterface extends BaseRepositoryInterface
{

}
