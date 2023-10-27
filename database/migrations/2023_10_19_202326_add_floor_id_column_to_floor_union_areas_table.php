<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFloorIdColumnToFloorUnionAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('floor_union_areas', function (Blueprint $table) {
            $table->integer('floor_id')->after('id');

            $table->index(['floor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('floor_union_areas', function (Blueprint $table) {
            $table->dropColumn('floor_id');
        });
    }
}