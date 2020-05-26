<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\RegistroDiario;
use App\Http\Models\Cliente;
use Illuminate\Support\Facades\Input;
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
    public function listRecords(Request $request){
        $fechaInicio = $request->fecha_i." 00:00:00";
        $fechaFin = $request->fecha_f." 23:59:59"; 
        $query = RegistroDiario::with('cliente','unidad','direccion.colonia','user', 'direccion.localidad')->whereBetween('created_at',[$fechaInicio,$fechaFin]);
        $listadoRegistros = $query;
        // dd($request->tipo_servicio);
        if($request->tipo_servicio =="diario"){
            $listadoRegistros = $query->where('tipo_registro',0);
        }else if($request->tipo_servicio =="programado"){
            $listadoRegistros = $query->where('tipo_registro',1);
        }
        if($request->base == 1){
            $listadoRegistros = $query->whereHas('unidad',function($q){
                $q->where('base',1);
            });
        }else if($request->base == 2){
            $listadoRegistros = $query->whereHas('unidad',function($q){
                $q->where('base',2);
            });
        }
        if($request->unidad != 'todas'){
            $listadoRegistros = $query->whereHas('unidad',function($q) use($request){
                $q->where('id',$request->unidad);
            });
        }
        $listadoRegistros->get();
        
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
                    $tipo = "Programado";
                }else{
                    $tipo = "Diario";
                }
                return $tipo;
            })
            ->rawColumns(['estatus','direccionCompleta','tipo_registro'])
            ->make(true);
        return $tabla;
    }

    public function reportePorCorteTaxi(Request $request){
        dd($request->all());
    }

    public function reportePorCliente(Request $request){

    }
}
