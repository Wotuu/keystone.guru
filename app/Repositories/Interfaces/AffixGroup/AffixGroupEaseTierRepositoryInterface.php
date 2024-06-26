<?php

namespace App\Repositories\Interfaces\AffixGroup;

use App\Models\AffixGroup\AffixGroupEaseTier;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @method AffixGroupEaseTier create(array $attributes)
 * @method AffixGroupEaseTier|null find(int $id, array|string $columns = ['*'])
 * @method AffixGroupEaseTier findOrFail(int $id, array|string $columns = ['*'])
 * @method AffixGroupEaseTier findOrNew(int $id, array|string $columns = ['*'])
 * @method bool save(AffixGroupEaseTier $model)
 * @method bool update(AffixGroupEaseTier $model, array $attributes = [], array $options = [])
 * @method bool delete(AffixGroupEaseTier $model)
 * @method Collection<AffixGroupEaseTier> all()
 */
interface AffixGroupEaseTierRepositoryInterface extends BaseRepositoryInterface
{

}
