<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUnidadIdInRegistrosDiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registros', function (Blueprint $table) {
            $table->dropForeign(['unidad_id']);
            $table->unsignedBigInteger('unidad_id')->nullable()->change();
            $table->foreign('unidad_id')->references('id')->on('unidades');
        });

        // Schema::table('registros_recurrentes', function (Blueprint $table) {
        //     $table->dropForeign(['unidad_id']);
        //     $table->unsignedBigInteger('unidad_id')->nullable()->change();
        //     $table->foreign('unidad_id')->references('id')->on('unidades'); 
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registros', function (Blueprint $table) {
            //
        });
    }
}
