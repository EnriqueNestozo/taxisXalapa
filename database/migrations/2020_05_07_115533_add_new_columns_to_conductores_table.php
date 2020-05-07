<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToConductoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conductores', function (Blueprint $table) {
            $table->tinyInteger('turno')->nullable();
            $table->string('calle',100)->nullable();
            $table->string('colonia',100)->nullable();
            $table->string('ciudad',100)->nullable();
            $table->string('licencia',50)->nullable();
            $table->date('vencimiento')->nullable();
            $table->string('tipo_sangre',5)->nullable();
            $table->string('persona_referencia',100)->nullable();
            $table->string('telefono_referencia',13)->nullable();
            $table->string('emergencia_referencia',100)->nullable();
            $table->string('telefono_emergencia_referencia',13)->nullable();

            $table->string('telefono_fijo',13)->nullable()->change();
            $table->string('celular',13)->nullable()->change();

            $table->dropColumn('curp');
            $table->dropColumn('rfc');
            $table->dropColumn('genero');
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
            $table->dropColumn('turno');
            $table->dropColumn('calle');
            $table->dropColumn('colonia');
            $table->dropColumn('ciudad');
            $table->dropColumn('licencia');
            $table->dropColumn('vencimiento');
            $table->dropColumn('tipo_sangre');
            $table->dropColumn('persona_referencia');
            $table->dropColumn('telefono_referencia');
            $table->dropColumn('emergencia_referencia');
            $table->dropColumn('telefono_emergecia_referencia');

            $table->string('telefono_fijo',10)->nullable()->change();
            $table->string('celular',10)->nullable()->change();

            $table->string('genero',1)->nullable();
            $table->string('curp',30)->nullable();
            $table->string('rfc',20)->nullable();
        });
    }
}
