<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDatetimeInRegistrosDiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registros_diarios', function (Blueprint $table) {
            $table->time('hora')->change();
        });
        Schema::table('registros_recurrentes', function (Blueprint $table) {
            $table->time('hora')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registros_diarios', function (Blueprint $table) {
            //
        });
    }
}