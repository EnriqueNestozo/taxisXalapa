<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Cat_municipio extends Model
{
    protected $table = 'cat_municipios';

    public $fillable = [
        'id',
        'cve_ent',
        'cve_mun',
        'nombre',
        'id_distrito'
    ];

    public function estado(){
        return $this->belongsTo('App\Models\Cat_estado', 'cve_ent', 'id');
    }

    public function localidades(){
        return $this->hasMany('App\Models\Cat_localidad');
    }

    public static function municipios($id){
        return Cat_municipio::select('id', 'nombre')->where('cve_ent', $id)->orderBy('id', 'ASC')->get();
    }
    
    public function getNombreAttribute($value)
	{		
		return mb_strtoupper($value, 'UTF-8');
    }
    
    public function direcciones(){
        return $this->hasMany('App\Http\Models\Direccion','municipio_id');
    }
}
