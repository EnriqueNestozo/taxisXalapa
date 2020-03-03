<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre', 'primer_apellido', 'segundo_apellido','telefono_fijo','celular','genero'
    ];
}
