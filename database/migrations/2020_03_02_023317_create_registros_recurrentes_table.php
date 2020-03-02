<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosRecurrentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros_recurrentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('hora');
            $table->string('dia_semana');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('direccion_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('direccion_id')->references('id')->on('direcciones');
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
        Schema::dropIfExists('registros_recurrentes');
    }
}
