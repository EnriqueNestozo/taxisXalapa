<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Conductor extends Model
{
    use SoftDeletes;
    protected $table = 'conductores';

    protected $fillable = [
        'nombre', 
        'primer_apellido', 
        'segundo_apellido',
        'telefono_fijo',
        'celular',
        'turno',
        'calle',
        'colonia',
        'ciudad',
        'licencia',
        'vencimiento',
        'tipo_sangre',
        'persona_referencia',
        'telefono_referencia',
        'emergencia_referencia',
        'telefono_emergencia_referencia'
    ];

    public function unidades()
    {
        return $this->belongsToMany('App\Http\Models\Unidad','conductores_unidades','conductor_id','unidad_id')->withPivot('turno','id');
    }

    public function documentos()
    {
        return $this->hasMany('App\Http\Models\Documento','conductor_id');
    }
}
