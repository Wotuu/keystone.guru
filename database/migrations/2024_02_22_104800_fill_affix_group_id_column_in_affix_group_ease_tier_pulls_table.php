<?php

use App\Models\AffixGroup\AffixGroupEaseTierPull;
use App\Service\AffixGroup\AffixGroupEaseTierServiceInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     *
     * @throws BindingResolutionException
     */
    public function up(): void
    {
        $rows = DB::select('
            SELECT * FROM affix_group_ease_tier_pulls;
        ');

        /** @var AffixGroupEaseTierServiceInterface $affixGroupEaseTierService */
        $affixGroupEaseTierService = app()->make(AffixGroupEaseTierServiceInterface::class);

        foreach ($rows as $row) {
            $row = (array)$row;

            $affixGroup = $affixGroupEaseTierService->getAffixGroupByString($row['current_affixes']);
            if ($affixGroup === null) {
                // Delete it through Eloquent so that it cleans up the relationships as well
                AffixGroupEaseTierPull::findOrFail($row['id'])->delete();
            } else {
                DB::update('
                UPDATE affix_group_ease_tier_pulls SET affix_group_id = :affixGroupId WHERE id = :id
            ', [
                    'affixGroupId' => $affixGroup->id,
                    'id'           => $row['id'],
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /** @noinspection SqlWithoutWhere */
        DB::update('
                UPDATE affix_group_ease_tier_pulls SET affix_group_id = 0;
            ');
    }
};
