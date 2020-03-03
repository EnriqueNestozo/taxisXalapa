<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosDiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros_diarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('hora');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('direccion_id');
            $table->unsignedBigInteger('unidad_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('direccion_id')->references('id')->on('direcciones');
            $table->foreign('unidad_id')->references('id')->on('unidades');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('registros_diarios');
    }
}
