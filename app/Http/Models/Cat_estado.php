<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Cat_estado extends Model
{
    protected $table = 'cat_estados';

    protected $fillable = [
        'nombre',
        'abreviatura',
    ];

    public function municipios()
    {
        return $this->hasMany('App\Models\Cat_municipio');
    }

    public function getNombreAttribute($value)
	{		
		return mb_strtoupper($value, 'UTF-8');
    }
    
    public function direcciones(){
        return $this->hasMany('App\Http\Models\Direccion','estado_id');
    }
}
