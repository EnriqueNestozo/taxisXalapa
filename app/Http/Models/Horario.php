<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horario';


    public function servicio(){
        return $this->belongsTo('App\Http\Models\Servicio','servicio_id');
    }
}
