<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatColoniasTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_colonias', function (Blueprint $table) {
            $table->bigIncrements('id');
      			$table->bigInteger('cve_ent')->unsigned();
      			$table->bigInteger('cve_mun')->unsigned();
      			$table->string('ciudad',200);
      			$table->string('zona',200);
            $table->bigInteger('codigo_postal');
            $table->string('asentamiento',200);
	          $table->string('tipo',200);
			//$table->foreign('cve_muni')->references('cve_mun')->on('cat_municipios')->unique()->unsigned();
            //$table->foreign('cve_ent')->references('cve_ent')->on('cat_municipios');

            $table->timestamps();
            $table->softDeletes();
        });
    }
}
