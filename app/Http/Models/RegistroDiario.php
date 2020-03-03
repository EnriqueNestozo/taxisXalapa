<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroDiario extends Model
{
    protected $table = 'registros_diarios';

    protected $fillable = [
        'hora', 'cliente_id', 'direccion_id'
    ];
}
