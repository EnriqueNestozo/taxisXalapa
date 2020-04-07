<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat_localidad extends Model
{
    protected $table = 'cat_localidades';

    protected $fillable = [
        'nombre',
    ];

    public function municipio(){
        return $this->belongsTo('App\Models\Cat_municipio', 'cve_mun');
    }

	public static function localidad($id){
        return CatLocalidad::select('id', 'nombre')->where('cve_mun', $id)->orderBy('id', 'ASC')->get();
    }

    public function getNombreAttribute($value)
	{		
		return mb_strtoupper($value, 'UTF-8');
	}    
}
