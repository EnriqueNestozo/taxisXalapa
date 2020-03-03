<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroRecurrente extends Model
{
    protected $table = 'registros_recurrentes';

    protected $fillable = [
        'hora', 'cliente_id', 'direccion_id'
    ];

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente','cliente_id');
    }

    public function direccion(){
        return $this->belongsTo('App\Models\Direccion','direccion_id');
    }

    public function unidad(){
        return $this->belongsTo('App\Models\Unidad','unidad_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
