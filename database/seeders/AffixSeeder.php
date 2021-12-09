<?php

namespace Database\Seeders;

use App\Models\Affix;
use App\Models\AffixGroup;
use App\Models\AffixGroupCoupling;
use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AffixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->_rollback();

        $this->command->info('Adding known affixes');

        $affixes = [
            new Affix(['key' => Affix::AFFIX_BOLSTERING, 'name' => 'affixes.bolstering.name', 'icon_file_id' => -1, 'description' => 'affixes.bolstering.description']),
            new Affix(['key' => Affix::AFFIX_BURSTING, 'name' => 'affixes.bursting.name', 'icon_file_id' => -1, 'description' => 'affixes.bursting.description']),
            new Affix(['key' => Affix::AFFIX_EXPLOSIVE, 'name' => 'affixes.explosive.name', 'icon_file_id' => -1, 'description' => 'affixes.explosive.description']),
            new Affix(['key' => Affix::AFFIX_FORTIFIED, 'name' => 'affixes.fortified.name', 'icon_file_id' => -1, 'description' => 'affixes.fortified.description']),
            new Affix(['key' => Affix::AFFIX_GRIEVOUS, 'name' => 'affixes.grievous.name', 'icon_file_id' => -1, 'description' => 'affixes.grievous.description']),
            new Affix(['key' => Affix::AFFIX_INFESTED, 'name' => 'affixes.infested.name', 'icon_file_id' => -1, 'description' => 'affixes.infested.description']),
            new Affix(['key' => Affix::AFFIX_NECROTIC, 'name' => 'affixes.necrotic.name', 'icon_file_id' => -1, 'description' => 'affixes.necrotic.description']),
            new Affix(['key' => Affix::AFFIX_QUAKING, 'name' => 'affixes.quaking.name', 'icon_file_id' => -1, 'description' => 'affixes.quaking.description']),
            new Affix(['key' => Affix::AFFIX_RAGING, 'name' => 'affixes.raging.name', 'icon_file_id' => -1, 'description' => 'affixes.raging.description']),
            new Affix(['key' => Affix::AFFIX_RELENTLESS, 'name' => 'affixes.relentless.name', 'icon_file_id' => -1, 'description' => 'affixes.relentless.description']),
            new Affix(['key' => Affix::AFFIX_SANGUINE, 'name' => 'affixes.sanguine.name', 'icon_file_id' => -1, 'description' => 'affixes.sanguine.description']),
            new Affix(['key' => Affix::AFFIX_SKITTISH, 'name' => 'affixes.skittish.name', 'icon_file_id' => -1, 'description' => 'affixes.skittish.description']),
            new Affix(['key' => Affix::AFFIX_TEEMING, 'name' => 'affixes.teeming.name', 'icon_file_id' => -1, 'description' => 'affixes.teeming.description']),
            new Affix(['key' => Affix::AFFIX_TYRANNICAL, 'name' => 'affixes.tyrannical.name', 'icon_file_id' => -1, 'description' => 'affixes.tyrannical.description']),
            new Affix(['key' => Affix::AFFIX_VOLCANIC, 'name' => 'affixes.volcanic.name', 'icon_file_id' => -1, 'description' => 'affixes.volcanic.description']),

            new Affix(['key' => Affix::AFFIX_REAPING, 'name' => 'affixes.reaping.name', 'icon_file_id' => -1, 'description' => 'affixes.reaping.description']),
            new Affix(['key' => Affix::AFFIX_BEGUILING, 'name' => 'affixes.beguiling.name', 'icon_file_id' => -1, 'description' => 'affixes.beguiling.description']),
            new Affix(['key' => Affix::AFFIX_AWAKENED, 'name' => 'affixes.awakened.name', 'icon_file_id' => -1, 'description' => 'affixes.awakened.description']),

            new Affix(['key' => Affix::AFFIX_INSPIRING, 'name' => 'affixes.inspiring.name', 'icon_file_id' => -1, 'description' => 'affixes.inspiring.description']),
            new Affix(['key' => Affix::AFFIX_SPITEFUL, 'name' => 'affixes.spiteful.name', 'icon_file_id' => -1, 'description' => 'affixes.inspiring.description']),
            new Affix(['key' => Affix::AFFIX_STORMING, 'name' => 'affixes.storming.name', 'icon_file_id' => -1, 'description' => 'affixes.storming.description']),

            new Affix(['key' => Affix::AFFIX_PRIDEFUL, 'name' => 'affixes.prideful.name', 'icon_file_id' => -1, 'description' => 'affixes.prideful.description']),
            new Affix(['key' => Affix::AFFIX_TORMENTED, 'name' => 'affixes.tormented.name', 'icon_file_id' => -1, 'description' => 'affixes.tormented.description']),
            new Affix(['key' => Affix::AFFIX_UNKNOWN, 'name' => 'affixes.unknown.name', 'icon_file_id' => -1, 'description' => 'affixes.unknown.description']),
            new Affix(['key' => Affix::AFFIX_INFERNAL, 'name' => 'affixes.infernal.name', 'icon_file_id' => -1, 'description' => 'affixes.infernal.description']),
        ];

        foreach ($affixes as $affix) {
            /** @var $affix Model */
            $affix->save();

            $iconName          = strtolower(str_replace(' ', '', $affix->key));
            $icon              = new File();
            $icon->model_id    = $affix->id;
            $icon->model_class = get_class($affix);
            $icon->disk        = 'public';
            $icon->path        = sprintf('images/affixes/%s.jpg', $iconName);
            $icon->save();

            $affix->icon_file_id = $icon->id;
            $affix->save();
        }

        $groups = [
            ['season_id' => 1, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SANGUINE, Affix::AFFIX_NECROTIC, Affix::AFFIX_INFESTED]],
            ['season_id' => 1, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BURSTING, Affix::AFFIX_SKITTISH, Affix::AFFIX_INFESTED]],
            ['season_id' => 1, 'seasonal_index' => 2, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_TEEMING, Affix::AFFIX_QUAKING, Affix::AFFIX_INFESTED]],
            ['season_id' => 1, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_RAGING, Affix::AFFIX_NECROTIC, Affix::AFFIX_INFESTED]],
            ['season_id' => 1, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BOLSTERING, Affix::AFFIX_SKITTISH, Affix::AFFIX_INFESTED]],
            ['season_id' => 1, 'seasonal_index' => 2, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_TEEMING, Affix::AFFIX_VOLCANIC, Affix::AFFIX_INFESTED]],
            ['season_id' => 1, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SANGUINE, Affix::AFFIX_GRIEVOUS, Affix::AFFIX_INFESTED]],
            ['season_id' => 1, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BOLSTERING, Affix::AFFIX_EXPLOSIVE, Affix::AFFIX_INFESTED]],
            ['season_id' => 1, 'seasonal_index' => 2, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BURSTING, Affix::AFFIX_QUAKING, Affix::AFFIX_INFESTED]],
            ['season_id' => 1, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_RAGING, Affix::AFFIX_VOLCANIC, Affix::AFFIX_INFESTED]],
            ['season_id' => 1, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_TEEMING, Affix::AFFIX_EXPLOSIVE, Affix::AFFIX_INFESTED]],
            ['season_id' => 1, 'seasonal_index' => 2, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BOLSTERING, Affix::AFFIX_GRIEVOUS, Affix::AFFIX_INFESTED]],

            ['season_id' => 2, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SANGUINE, Affix::AFFIX_NECROTIC, Affix::AFFIX_REAPING]],
            ['season_id' => 2, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BURSTING, Affix::AFFIX_SKITTISH, Affix::AFFIX_REAPING]],
            ['season_id' => 2, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_TEEMING, Affix::AFFIX_QUAKING, Affix::AFFIX_REAPING]],
            ['season_id' => 2, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_RAGING, Affix::AFFIX_NECROTIC, Affix::AFFIX_REAPING]],
            ['season_id' => 2, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BOLSTERING, Affix::AFFIX_SKITTISH, Affix::AFFIX_REAPING]],
            ['season_id' => 2, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_TEEMING, Affix::AFFIX_VOLCANIC, Affix::AFFIX_REAPING]],
            ['season_id' => 2, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_TEEMING, Affix::AFFIX_QUAKING, Affix::AFFIX_REAPING]],
            ['season_id' => 2, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_RAGING, Affix::AFFIX_NECROTIC, Affix::AFFIX_REAPING]],
            ['season_id' => 2, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BOLSTERING, Affix::AFFIX_SKITTISH, Affix::AFFIX_REAPING]],
            ['season_id' => 2, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_TEEMING, Affix::AFFIX_VOLCANIC, Affix::AFFIX_REAPING]],
            ['season_id' => 2, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_TEEMING, Affix::AFFIX_EXPLOSIVE, Affix::AFFIX_REAPING]],
            ['season_id' => 2, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BOLSTERING, Affix::AFFIX_GRIEVOUS, Affix::AFFIX_REAPING]],

            ['season_id' => 3, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BOLSTERING, Affix::AFFIX_SKITTISH, Affix::AFFIX_BEGUILING]],
            ['season_id' => 3, 'seasonal_index' => 2, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BURSTING, Affix::AFFIX_NECROTIC, Affix::AFFIX_BEGUILING]],
            ['season_id' => 3, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SANGUINE, Affix::AFFIX_QUAKING, Affix::AFFIX_BEGUILING]],
            ['season_id' => 3, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BOLSTERING, Affix::AFFIX_EXPLOSIVE, Affix::AFFIX_BEGUILING]],
            ['season_id' => 3, 'seasonal_index' => 2, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BURSTING, Affix::AFFIX_VOLCANIC, Affix::AFFIX_BEGUILING]],
            ['season_id' => 3, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_RAGING, Affix::AFFIX_NECROTIC, Affix::AFFIX_BEGUILING]],
            ['season_id' => 3, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_TEEMING, Affix::AFFIX_QUAKING, Affix::AFFIX_BEGUILING]],
            ['season_id' => 3, 'seasonal_index' => 2, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BURSTING, Affix::AFFIX_SKITTISH, Affix::AFFIX_BEGUILING]],
            ['season_id' => 3, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BOLSTERING, Affix::AFFIX_GRIEVOUS, Affix::AFFIX_BEGUILING]],
            ['season_id' => 3, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_RAGING, Affix::AFFIX_EXPLOSIVE, Affix::AFFIX_BEGUILING]],
            ['season_id' => 3, 'seasonal_index' => 2, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SANGUINE, Affix::AFFIX_GRIEVOUS, Affix::AFFIX_BEGUILING]],
            ['season_id' => 3, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_TEEMING, Affix::AFFIX_VOLCANIC, Affix::AFFIX_BEGUILING]],

            ['season_id' => 4, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BOLSTERING, Affix::AFFIX_SKITTISH, Affix::AFFIX_AWAKENED]],
            ['season_id' => 4, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BURSTING, Affix::AFFIX_NECROTIC, Affix::AFFIX_AWAKENED]],
            ['season_id' => 4, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SANGUINE, Affix::AFFIX_QUAKING, Affix::AFFIX_AWAKENED]],
            ['season_id' => 4, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BOLSTERING, Affix::AFFIX_EXPLOSIVE, Affix::AFFIX_AWAKENED]],
            ['season_id' => 4, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BURSTING, Affix::AFFIX_VOLCANIC, Affix::AFFIX_AWAKENED]],
            ['season_id' => 4, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_RAGING, Affix::AFFIX_NECROTIC, Affix::AFFIX_AWAKENED]],
            ['season_id' => 4, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_TEEMING, Affix::AFFIX_QUAKING, Affix::AFFIX_AWAKENED]],
            ['season_id' => 4, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BURSTING, Affix::AFFIX_SKITTISH, Affix::AFFIX_AWAKENED]],
            ['season_id' => 4, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BOLSTERING, Affix::AFFIX_GRIEVOUS, Affix::AFFIX_AWAKENED]],
            ['season_id' => 4, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_RAGING, Affix::AFFIX_EXPLOSIVE, Affix::AFFIX_AWAKENED]],
            ['season_id' => 4, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SANGUINE, Affix::AFFIX_GRIEVOUS, Affix::AFFIX_AWAKENED]],
            ['season_id' => 4, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_TEEMING, Affix::AFFIX_VOLCANIC, Affix::AFFIX_AWAKENED]],

            ['season_id' => 5, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SPITEFUL, Affix::AFFIX_GRIEVOUS, Affix::AFFIX_PRIDEFUL]],
            ['season_id' => 5, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_INSPIRING, Affix::AFFIX_NECROTIC, Affix::AFFIX_PRIDEFUL]],
            ['season_id' => 5, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SANGUINE, Affix::AFFIX_QUAKING, Affix::AFFIX_PRIDEFUL]],
            ['season_id' => 5, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_RAGING, Affix::AFFIX_EXPLOSIVE, Affix::AFFIX_PRIDEFUL]],
            ['season_id' => 5, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SPITEFUL, Affix::AFFIX_VOLCANIC, Affix::AFFIX_PRIDEFUL]],
            ['season_id' => 5, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BOLSTERING, Affix::AFFIX_NECROTIC, Affix::AFFIX_PRIDEFUL]],
            ['season_id' => 5, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_INSPIRING, Affix::AFFIX_STORMING, Affix::AFFIX_PRIDEFUL]],
            ['season_id' => 5, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BURSTING, Affix::AFFIX_EXPLOSIVE, Affix::AFFIX_PRIDEFUL]],
            ['season_id' => 5, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SANGUINE, Affix::AFFIX_GRIEVOUS, Affix::AFFIX_PRIDEFUL]],
            ['season_id' => 5, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_RAGING, Affix::AFFIX_QUAKING, Affix::AFFIX_PRIDEFUL]],
            ['season_id' => 5, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BURSTING, Affix::AFFIX_VOLCANIC, Affix::AFFIX_PRIDEFUL]],
            ['season_id' => 5, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BOLSTERING, Affix::AFFIX_STORMING, Affix::AFFIX_PRIDEFUL]],

            ['season_id' => 6, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_INSPIRING, Affix::AFFIX_QUAKING, Affix::AFFIX_TORMENTED]],
            ['season_id' => 6, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SANGUINE, Affix::AFFIX_NECROTIC, Affix::AFFIX_TORMENTED]],
            ['season_id' => 6, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BOLSTERING, Affix::AFFIX_EXPLOSIVE, Affix::AFFIX_TORMENTED]],
            ['season_id' => 6, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BURSTING, Affix::AFFIX_STORMING, Affix::AFFIX_TORMENTED]],
            ['season_id' => 6, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_RAGING, Affix::AFFIX_VOLCANIC, Affix::AFFIX_TORMENTED]],
            ['season_id' => 6, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_INSPIRING, Affix::AFFIX_GRIEVOUS, Affix::AFFIX_TORMENTED]],
            ['season_id' => 6, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_SPITEFUL, Affix::AFFIX_NECROTIC, Affix::AFFIX_TORMENTED]],
            ['season_id' => 6, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_BOLSTERING, Affix::AFFIX_QUAKING, Affix::AFFIX_TORMENTED]],
            ['season_id' => 6, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_SANGUINE, Affix::AFFIX_STORMING, Affix::AFFIX_TORMENTED]],
            ['season_id' => 6, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_RAGING, Affix::AFFIX_EXPLOSIVE, Affix::AFFIX_TORMENTED]],
            ['season_id' => 6, 'seasonal_index' => 1, 'affixes' => [Affix::AFFIX_TYRANNICAL, Affix::AFFIX_BURSTING, Affix::AFFIX_VOLCANIC, Affix::AFFIX_TORMENTED]],
            ['season_id' => 6, 'seasonal_index' => 0, 'affixes' => [Affix::AFFIX_FORTIFIED, Affix::AFFIX_SPITEFUL, Affix::AFFIX_GRIEVOUS, Affix::AFFIX_TORMENTED]],
        ];

        foreach ($groups as $groupArr) {
            $group = AffixGroup::create([
                'season_id'      => $groupArr['season_id'],
                'seasonal_index' => $groupArr['seasonal_index'] ?? null,
            ]);

            foreach ($groupArr['affixes'] as $affixName) {
                $affix = $this->_findAffix($affixes, $affixName);

                AffixGroupCoupling::create([
                    'affix_id'       => $affix->id,
                    'affix_group_id' => $group->id,
                ]);
            }
        }
    }

    /**
     * Finds an affix by name in a list of affixes.
     *
     * @param $affixes Affix[]
     * @param $affixName string
     * @return bool|Affix
     */
    private function _findAffix(array $affixes, string $affixName)
    {
        $result = false;

        foreach ($affixes as $affix) {
            if ($affix->key === $affixName) {
                $result = $affix;
                break;
            }
        }

        if (!$result) {
            $this->command->error(sprintf('Unable to find affix %s', $affixName));
        }

        return $result;
    }

    /**
     *
     */
    private function _rollback()
    {
        DB::table('affixes')->truncate();
        DB::table('affix_groups')->truncate();
        DB::table('affix_group_couplings')->truncate();
        DB::table('files')->where('model_class', 'App\Models\Affix')->delete();
    }
}
