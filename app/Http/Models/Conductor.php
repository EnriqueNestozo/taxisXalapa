<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    protected $table = 'conductores';

    protected $fillable = [
        'nombre', 'primer_apellido', 'segundo_apellido','telefono_fijo','celular','genero', 'curp','rfc'
    ];
}
