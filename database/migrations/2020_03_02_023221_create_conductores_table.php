<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConductoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conductores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',100);
            $table->string('primer_apellido',100)->nullable();
            $table->string('segundo_apellido',100)->nullable();
            $table->string('telefono_fijo',10)->nullable();
            $table->string('celular',10)->nullable();
            $table->string('genero',1)->nullable();
            $table->string('curp',30)->nullable();
            $table->string('rfc',20)->nullable();
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
        Schema::dropIfExists('conductores');
    }
}
