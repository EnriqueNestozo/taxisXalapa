<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMunicipioAndEntidadToDireccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direcciones', function (Blueprint $table) {
            $table->dropColumn(['numero','localidad','colonia']);
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('cat_estados');
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->foreign('municipio_id')->references('id')->on('cat_municipios');
            $table->unsignedBigInteger('localidad_id')->nullable();
            $table->foreign('localidad_id')->references('id')->on('cat_localidades');
            $table->unsignedBigInteger('colonia_id')->nullable();
            $table->foreign('colonia_id')->references('id')->on('cat_colonias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direcciones', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->string('colonia',200);
            $table->string('numero',5);
            $table->string('localidad',200)->nullable();
            $table->dropColumn(['estado_id','municipio_id','localidad_id','colonia_id']);
        });
    }
}
