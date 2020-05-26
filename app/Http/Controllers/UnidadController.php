<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Unidad;
use App\Http\Models\ConductorUnidad;
use DataTables;
use DB;

class UnidadController extends Controller
{
    public function __construct(){
        // $this->middleware('client-credential');
    }

    public function create(Request $request)
    {
        try{
            DB::beginTransaction();
            $unidad= null;
            if($request->idUnidad){
                $unidad = Unidad::find($request->idUnidad);
                $unidad->marca = ($request->marca)?$request->marca : '';
                $unidad->modelo = ($request->modelo)?$request->modelo : '';
                $unidad->placas = ($request->placas)?$request->placas : '';
                $unidad->numero = ($request->numero)? $request->numero : '';
                $unidad->tarjeta_circulacion = ($request->tarjeta_circulacion)? $request->tarjeta_circulacion : '';
                $unidad->numero_economico = $request->numero_economico;
                $unidad->base = $request->base;
                $unidad->save();
            }else{
                // dd($request->all());
                $unidad = Unidad::create($request->all());
            }
            $this->borrarConductores($unidad->id);
            // if($request->conductor1Select){
            //     $conductorUnidad = new ConductorUnidad();
            //     $conductorUnidad->conductor_id = $request->conductor1Select;
            //     $conductorUnidad->unidad_id = $unidad->id;
            //     $conductorUnidad->save();
            // }
            // if($request->conductor2Select){
            //     $conductorUnidad = new ConductorUnidad();
            //     $conductorUnidad->conductor_id = $request->conductor2Select;
            //     $conductorUnidad->unidad_id = $unidad->id;
            //     $conductorUnidad->save();
            // }
            DB::commit();
            return response()->json($unidad,201);
        }catch (\PDOException $e) {
            DB::rollBack();
            return response()->json($e,500);
        }
        
    }

    public function borrarConductores($idUnidad){
        $conductorUnidad = ConductorUnidad::where('unidad_id',$idUnidad)->get();
        // dd($conductorUnidad);
        foreach ($conductorUnidad as $conductor) {
            $conductor->delete();
        }
    }

    //Parece que no se usa
    public function update(Request $request)
    {
        $unidad = Unidad::find($request->id);
        $unidad->update($request->all());
        return response()->json($unidad,201);
    }

    public function delete(Request $request)
    {
        try{
            DB::beginTransaction();
            $unidad = Unidad::find($request->idUnidad);
            $unidad->delete();
            $listadoConductorUnidad = ConductorUnidad::where('unidad_id',$request->idUnidad)->get();
            foreach ($listadoConductorUnidad as $conductorUnidad) {
                $conductorUnidad->delete();
            }
            DB::commit();
            return response()->json($conductorUnidad,201);
        }catch(\PDOException $e){
            DB::rollBack();
            return response()->json($e,500);
        }
        return response()->json(null,204);
    }

    public function show($idUnidad)
    {
        $unidad = Unidad::with('conductores')->find($idUnidad);
        return response()->json($unidad,201);
    }

    /*
        No se usa
    */
    public function getUnidades()
    {
        $listadounidades = Unidad::orderBy('numero')->get();
        return response()->json($listadounidades,201);
    }

    public function conductoresPorUnidad($idUnidad){
        $conductorUnidad = Unidad::with('conductores')->where('id',$idUnidad)->get();
        return response()->json($conductorUnidad,201);
    }

    public function CrearRelacionconductoresUnidad(Request $request){
        try{
            DB::beginTransaction();
            $conductorUnidad = new ConductorUnidad();
            $conductorUnidad->conductor_id = $request->conductorSelect;
            $conductorUnidad->unidad_id = $request->idUnidad;
            $conductorUnidad->turno = $request->turnoSelect;
            $conductorUnidad->save();
            DB::commit();
            return response()->json($conductorUnidad,201);
        }catch(\PDOException $e){
            DB::rollBack();
            return response()->json($e,500);
        }
    }

    public function EliminarRelacionconductoresUnidad(Request $request){
        try{
            DB::beginTransaction();
            $conductorUnidad = ConductorUnidad::find($request->id);
            $conductorUnidad->delete();
            DB::commit();
            return response()->json($conductorUnidad,201);
        }catch(\PDOException $e){
            DB::rollBack();
            return response()->json($e,500);
        }
    }

    public function listUnits()
    {
        $listadoUnidades = Unidad::withCount('conductores')->get();
        $tabla = Datatables::of($listadoUnidades)
            ->editColumn('conductores_count', function($fila){
                $numeroConductoresIcons = null;
                for ($i=0; $i < $fila->conductores_count ; $i++) { 
                    $numeroConductoresIcons.='<span class="material-icons">face</span>';
                }
                return $numeroConductoresIcons;
            })
            ->addColumn('action',function($fila){
                $accion = null;
                $accion.= "<button class='btn btn-primary btn-link btn-sm' type='button' data-original-title='Editar unidad' onClick='editarUnidad(".$fila->id.")'><i class='material-icons'>edit</i></button>";
                $accion.= "<button class='btn btn-danger btn-link btn-sm' type='button' data-original-title='Eliminar unidad' onClick='eliminarUnidad(".$fila->id.")'><i class='material-icons'>close</i></button>";
                $accion.= "<button class='btn btn-info btn-link btn-sm' type='button' data-original-title='Agregar chofer' onClick='agregarConductor(".$fila->id.")'><i class='material-icons'>person_add</i></button>";
                return $accion;
            })
            ->rawColumns(['action','conductores_count'])
            ->make(true);
        return $tabla;
        // return response()->json($listadoClientes,201);
    }
}
