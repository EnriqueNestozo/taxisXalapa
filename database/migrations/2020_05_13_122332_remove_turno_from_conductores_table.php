<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTurnoFromConductoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conductores', function (Blueprint $table) {
            $table->dropColumn('turno');
        });
        Schema::table('conductores_unidades', function (Blueprint $table) {
            $table->tinyInteger('turno')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conductores', function (Blueprint $table) {
            $table->tinyInteger('turno')->nullable();
        });
        Schema::table('conductores_unidades', function (Blueprint $table) {
            $table->dropColumn('turno');
        });
    }
}
