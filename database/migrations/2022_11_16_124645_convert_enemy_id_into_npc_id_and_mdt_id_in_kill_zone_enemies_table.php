<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get rid of all enemies assigned to pulls that have since been deleted
        DB::delete('
            DELETE `kill_zone_enemies`.*
            FROM `kill_zone_enemies`
                 LEFT JOIN `enemies` ON `enemies`.`id` = `kill_zone_enemies`.`enemy_id`
            WHERE `enemies`.`id` is null;
        ');

        DB::update('
            UPDATE `kill_zone_enemies`
                LEFT JOIN `enemies` ON `enemies`.`id` = `kill_zone_enemies`.`enemy_id`
            SET `kill_zone_enemies`.`npc_id` = coalesce(`enemies`.`mdt_npc_id`, `enemies`.`npc_id`), `kill_zone_enemies`.`mdt_id` = `enemies`.`mdt_id`
                WHERE `enemies`.`mdt_id` is not null;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::update('
            UPDATE `kill_zone_enemies`
                SET `kill_zone_enemies`.`npc_id` = null, `kill_zone_enemies`.`mdt_id` = null;
        ');
    }
};
