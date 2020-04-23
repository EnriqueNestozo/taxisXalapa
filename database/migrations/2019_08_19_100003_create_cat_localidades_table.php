<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatLocalidadesTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_localidades', function (Blueprint $table) {
            $table->bigIncrements('id');
      			$table->bigInteger('cve_ent')->unsigned();
      			$table->bigInteger('cve_mun')->unsigned();
      			$table->bigInteger('cve_loc')->unsigned();
            $table->string('nombre',200);
      			$table->double('lat_decimal');
      			$table->double('lon_decimal');
      			$table->double('altitud');
            $table->timestamps();
            $table->softDeletes();

			//$table->foreign(['cve_mun','cve_ent'])->references(['cve_mun','cve_ent'])->on('cat_municipios')->onDelete('cascade')->unique()->unsigned();
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
        Schema::dropIfExists('cat_localidades');
    }
}
