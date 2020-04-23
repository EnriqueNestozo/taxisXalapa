<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatMunicipiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_municipios', function (Blueprint $table) {
            $table->bigIncrements('id'); //id nacional
            $table->bigInteger('cve_ent')->unsigned();
            $table->bigInteger('cve_mun')->unsigned();
            $table->bigInteger('cve_bus')->unsigned();
            $table->string('nombre',200);
            $table->string('mun_director',200);
            $table->foreign('cve_ent')->references('id')->on('cat_estados');
            $table->integer('id_distrito')->nullable();
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
        Schema::dropIfExists('cat_municipios');
    }
}
