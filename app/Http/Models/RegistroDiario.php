<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RegistroDiario extends Model
{
    use SoftDeletes;
    protected $table = 'registros';

    protected $fillable = [
        'hora', 'cliente_id', 'direccion_id'
    ];

    public function cliente(){
        return $this->belongsTo('App\Http\Models\Cliente','cliente_id');
    }

    public function direccion(){
        return $this->belongsTo('App\Http\Models\Direccion','direccion_id');
    }

    public function unidad(){
        return $this->belongsTo('App\Http\Models\Unidad','unidad_id');
    }

    public function user(){
        return $this->belongsTo('App\Http\Models\User','user_id');
    }

    // public function horarios(){
    //     return $this->hasMany('App\Http\Models\Horario','registro_id');
    // }

    public function servicio(){
        return $this->belongsTo('App\Http\Models\Servicio','servicio_id');
    }
    

}
