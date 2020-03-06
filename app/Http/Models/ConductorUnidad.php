<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ConductorUnidad extends Model
{
    protected $table = 'conductores_unidades';

    protected $fillable = [
        'conductor_id', 'unidad_id'
    ];
}
