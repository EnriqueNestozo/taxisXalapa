<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horario';


    public function registroDiarios(){
        return $this->belongsTo('App\Http\Models\RegistroDiario','registro_id');
    }
}
