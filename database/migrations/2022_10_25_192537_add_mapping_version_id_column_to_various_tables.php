<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLES = [
        'dungeon_floor_switch_markers',
        'enemies',
        'enemy_packs',
        'enemy_patrols',
        'mountable_areas',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('map_icons', function (Blueprint $table) {
            $table->integer('mapping_version_id')->after('id')->default(null)->nullable(true);

            $table->dropIndex('map_comments_dungeon_route_id_index');
            $table->index(['dungeon_route_id']);

            $table->dropIndex('map_comments_floor_id_dungeon_route_id_index');
            $table->index(['floor_id', 'dungeon_route_id', 'mapping_version_id'], 'map_icons_floor_route_version_index');
        });

        foreach (self::TABLES as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->integer('mapping_version_id')->after('id')->default(0);

                $table->dropIndex(['floor_id']);
                $table->index(['floor_id', 'mapping_version_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (self::TABLES as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('mapping_version_id');

                $table->index('floor_id');
                $table->dropIndex(['floor_id', 'mapping_version_id']);
            });
        }
        Schema::table('map_icons', function (Blueprint $table) {
            $table->dropColumn('mapping_version_id');
        });
    }
};
