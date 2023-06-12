<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuidKeyToEnemyPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('combatlog')->table('enemy_positions', function (Blueprint $table) {
            $table->unique('guid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('combatlog')->table('enemy_positions', function (Blueprint $table) {
            $table->dropUnique('guid');
        });
    }
}
