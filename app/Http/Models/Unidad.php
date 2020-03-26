<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'unidades';

    protected $fillable = [
        'placas', 'numero'
    ];

    public function conductores()
    {
        return $this->belongsToMany('App\Http\Models\Conductor','conductores_unidades', 'unidad_id','conductor_id')->withTimestamps();
    }

    public function registrosDiarios(){
        return $this->hasMany('App\Http\Models\RegistroDiario','unidad_id');
    }

    public function registrosRecurrentes(){
        return $this->hasMany('App\Http\Models\RegistroRecurrente','unidad_id');
    }
}
