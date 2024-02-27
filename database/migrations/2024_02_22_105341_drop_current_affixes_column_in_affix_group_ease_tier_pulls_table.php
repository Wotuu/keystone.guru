<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('affix_group_ease_tier_pulls', function (Blueprint $table) {
            $table->dropColumn('current_affixes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('affix_group_ease_tier_pulls', function (Blueprint $table) {
            $table->string('current_affixes')->after('affix_group_id');
        });
    }
};
