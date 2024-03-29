<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('overpulled_enemies', function (Blueprint $table) {
            $table->integer('mdt_id')->default(null)->nullable()->after('kill_zone_id');
            $table->integer('npc_id')->default(null)->nullable()->after('kill_zone_id');

            $table->index(['npc_id', 'mdt_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overpulled_enemies', function (Blueprint $table) {
            $table->index(['npc_id', 'mdt_id']);

            $table->dropColumn('mdt_id');
            $table->dropColumn('npc_id');
        });
    }
};
