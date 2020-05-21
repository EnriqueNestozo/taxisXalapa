<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones';

    protected $fillable = [
        'calle', 'colonia', 'numero','referencia','localidad','cliente_id','es_destino'
    ];

    public function cliente(){
        return $this->belongsTo('App\Http\Models\Cliente','cliente_id');
    }

    public function registrosDiarios(){
        return $this->hasMany('App\Http\Models\RegistroDiario','direccion_id');
    }

    public function registrosRecurrentes(){
        return $this->hasMany('App\Http\Models\RegistroRecurrente','direccion_id');
    }

    public function municipio(){
        return $this->belongsTo('App\Http\Models\Cat_municipio','municipio_id');
    }

    public function localidad(){
        return $this->belongsTo('App\Http\Models\Cat_localidad','localidad_id');
    }

    public function colonia(){
        return $this->belongsTo('App\Http\Models\Cat_colonia','colonia_id');
    }
}
