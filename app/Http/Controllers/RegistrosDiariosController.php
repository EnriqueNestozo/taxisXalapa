<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\RegistroDiario;
use DataTables;

class RegistrosDiariosController extends Controller
{
    public function listRecords(){
        $listadoRegistros = RegistroDiario::all();
        $tabla = Datatables::of($listadoRegistros)
                    ->addColumn('action',function($fila){
                        $accion = null;
                        $accion.= "<button class='btn btn-primary btn-link btn-sm' type='button' data-original-title='Editar Registro' onClick='editarRegistro(".$fila->id.")'><i class='material-icons'>edit</i></button>";
                        $accion.= "<button class='btn btn-danger btn-link btn-sm' type='button' data-original-title='Eliminar Registro' onClick='eliminarRegistro(".$fila->id.")'><i class='material-icons'>close</i></button>";
                        return $accion;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        return $tabla;
    }
}
