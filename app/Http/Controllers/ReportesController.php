<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\RegistroDiario;
use App\Http\Models\Cliente;
use App\Http\Models\Unidad;
use App\Http\Models\Direccion;
use App\Http\Models\Cat_municipio;
use App\Http\Models\Cat_localidad;
use App\Http\Models\Cat_colonia;
use App\Http\Models\Horario;
use DataTables;
use DB;

class ReportesController extends Controller
{
    public function listRecords(){
        $listadoRegistros = RegistroDiario::with('cliente','unidad','direccion.colonia','user', 'direccion.localidad')->get();
        
        $tabla = Datatables::of($listadoRegistros)
            ->editColumn('estatus',function($fila){
                $estatus = null;
                if($fila['estatus']==null){
                    $estatus= '<span class="badge badge-info">Enviado</span>';
                }
                if($fila['estatus']==1){
                    $estatus= '<span class="badge badge-warning">Sin unidad</span>';
                }
                if($fila['estatus']==2){
                    $estatus= '<span class="badge" style="background-color:red; color:white">Cancelado</span>';
                }
                return $estatus;
            })
            ->addColumn('direccionCompleta',function($fila){
                $direccionCompleta = $fila['direccion']->calle.', Col. '.$fila['direccion']['colonia']->asentamiento. ', '.$fila['direccion']['localidad']->nombre;
                return $direccionCompleta;
            })
            ->editColumn('tipo_registro', function($fila){
                $tipo = null;
                if($fila['tipo_registro']==1){
                    $tipo = "Recurrente";
                }else{
                    $tipo = "Diario";
                }
                return $tipo;
            })
            ->rawColumns(['estatus','direccionCompleta','tipo_registro'])
            ->make(true);
        return $tabla;
    }
}
