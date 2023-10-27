<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTargetFloorIdColumnNullableInFloorUnionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('floor_unions', function (Blueprint $table) {
            $table->integer('target_floor_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('floor_unions', function (Blueprint $table) {
            $table->integer('target_floor_id')->nullable(false)->change();
        });
    }
}