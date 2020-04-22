<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use SoftDeletes;
    protected $table = 'servicios';

    public function cliente(){
        return $this->belongsTo('App\Http\Models\Cliente','cliente_id');
    }

    public function direccion(){
        return $this->belongsTo('App\Http\Models\Direccion','direccion_id');
    }

    public function user(){
        return $this->belongsTo('App\Http\Models\User','user_id');
    }

    public function horarios(){
        return $this->hasMany('App\Http\Models\Horario','servicio_id');
    }

    public function registros(){
        return $this->hasMany('App\Http\Models\RegistroDiario','servicio_id');
    }


}
