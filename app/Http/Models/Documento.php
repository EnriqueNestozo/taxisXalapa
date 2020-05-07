<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    public function conductor()
    {
        return $this->belongsTo('App\Http\Models\Conductor','conductor_id');
    }
}
