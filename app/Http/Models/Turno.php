<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = 'turnos';

    public function usuarios(){
        return $this->hasMany('App\Http\Models\User','turno_id');
    }
}
