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
        Schema::table('kill_zones', function (Blueprint $table) {
            $table->integer('floor_id')->nullable()->default(null)->change();
        });

        DB::update('UPDATE `kill_zones` SET `floor_id` = null WHERE `floor_id` <= 0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kill_zones', function (Blueprint $table) {
            $table->integer('floor_id')->nullable(false)->default(0)->change();
        });
    }
};
