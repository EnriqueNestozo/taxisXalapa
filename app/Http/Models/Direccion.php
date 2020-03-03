<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones';

    protected $fillable = [
        'calle', 'colonia', 'numero','referencia','localidad','cliente_id'
    ];
}
