<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidad extends Model
{
    use SoftDeletes;
    protected $table = 'unidades';

    protected $fillable = [
        'placas', 'numero', 'numero_economico'
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
