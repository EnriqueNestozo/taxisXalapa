<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones';

    protected $fillable = [
        'calle', 'colonia', 'numero','referencia','localidad','cliente_id'
    ];

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente','cliente_id');
    }

    public function registrosDiarios(){
        return $this->hasMany('App\Models\RegistroDiario','direccion_id');
    }

    public function registrosRecurrentes(){
        return $this->hasMany('App\Models\RegistroRecurrente','direccion_id');
    }
}
