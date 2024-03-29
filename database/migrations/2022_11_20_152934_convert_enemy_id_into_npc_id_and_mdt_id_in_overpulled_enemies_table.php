<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::delete('
            DELETE `overpulled_enemies`.*
            FROM `overpulled_enemies`
                 LEFT JOIN `enemies` ON `enemies`.`id` = `overpulled_enemies`.`enemy_id`
            WHERE `enemies`.`id` is null;
        ');

        DB::update('
            UPDATE `overpulled_enemies`
                LEFT JOIN `enemies` ON `enemies`.`id` = `overpulled_enemies`.`enemy_id`
            SET `overpulled_enemies`.`npc_id` = coalesce(`enemies`.`mdt_npc_id`, `enemies`.`npc_id`), `overpulled_enemies`.`mdt_id` = `enemies`.`mdt_id`
                WHERE `enemies`.`mdt_id` is not null;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::update('
            UPDATE `overpulled_enemies`
                SET `overpulled_enemies`.`npc_id` = null, `overpulled_enemies`.`mdt_id` = null;
        ');
    }
};
