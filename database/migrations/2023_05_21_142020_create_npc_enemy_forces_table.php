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
        Schema::create('npc_enemy_forces', function (Blueprint $table) {
            $table->id();
            $table->integer('mapping_version_id');
            $table->integer('npc_id');
            $table->integer('enemy_forces')->default(0);
            $table->integer('enemy_forces_teeming')->nullable()->default(null);

            $table->index(['mapping_version_id', 'npc_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('npc_enemy_forces');
    }
};
