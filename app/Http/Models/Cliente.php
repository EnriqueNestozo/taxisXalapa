<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre', 'primer_apellido', 'segundo_apellido','telefono_fijo','celular','genero'
    ];

    public function direcciones(){
        return $this->hasMany('App\Models\Direccion','cliente_id');
    }

    public function registrosDiarios(){
        return $this->hasMany('App\Models\RegistroDiario','cliente_id');
    }
}
