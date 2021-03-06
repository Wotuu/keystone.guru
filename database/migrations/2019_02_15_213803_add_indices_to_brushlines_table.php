<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndicesToBrushlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brushlines', function (Blueprint $table) {
            $table->index(['dungeon_route_id', 'floor_id']);
            $table->index('polyline_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brushlines', function (Blueprint $table) {
            $table->dropIndex(['polyline_id']);
            $table->dropIndex(['dungeon_route_id', 'floor_id']);
        });
    }
}
