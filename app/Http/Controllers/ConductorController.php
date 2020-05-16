<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Conductor;
use App\Http\Models\Documento;
use App\Http\Models\ConductorUnidad;
use App\Http\Controllers\Storage;
use App\Http\Controllers\File;
use DB;
use DateTime;
use DataTables;

class ConductorController extends Controller
{
    public function __construct(){
        // $this->middleware('client-credential');
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {  
            $datos = $request->all();
            $fecha = strtotime($request->vencimiento);
            $newformat = date('Y-m-d',$fecha);
            $datos['vencimiento'] = $newformat;
            $conductor = null;
            if($request->idConductor){
                $conductor = Conductor::find($request->idConductor);
                $conductor->update($datos);
            }else{  
                $conductor = Conductor::create($datos);
                $conductor->save();
                $request->request->add(['idConductor' => $conductor->id]);
            }
            $this->saveDoc($request);
            DB::commit();
            return response()->json($conductor,201);
        }catch (\PDOException $e) {      
            DB::rollBack();
            $succes = 'Fail'; 
            $folio = 'Intente de nuevo';       
            return response()->json($e,500);
        }
            
        
    }

    public function update($request)
    {
        $conductor = Conductor::find($request->id);
        $conductor->update($request->all());
        return response()->json($conductor,201);
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {  
            $conductor = Conductor::find($request->id);
            $conductor->delete();
            $listadoConductorUnidad = ConductorUnidad::where('conductor_id',$request->id)->get();
            foreach ($listadoConductorUnidad as $conductorUnidad) {
                $conductorUnidad->delete();
            }
            DB::commit();
            return response()->json($conductor,201);
        }catch (\PDOException $e) {      
            DB::rollBack();
            $succes = 'Fail'; 
            $folio = 'Intente de nuevo';       
            return response()->json($e,500);
        }
    }

    public function show($idConductor)
    {
        $conductor = Conductor::with('documentos')->find($idConductor);
        return response()->json($conductor,201);
    }

     //Trae el listado de los choferes para select
     public function listadoConductores(){
        $listadoConductores = Conductor::select('id','nombre','primer_apellido','segundo_apellido')->get();
        // dd($listadoConductores);
        return $listadoConductores; 
    }

    //Trae el listado de conductores para datatable
    public function listConductores(){
        $listadoConductores = Conductor::with('unidades')->get();
        try{
            $tabla = Datatables::of($listadoConductores)
            ->addColumn('action',function($fila){
                $accion = null;
                $accion.= "<button class='btn btn-primary btn-link btn-sm' type='button' data-original-title='Modificar conductor' onClick='modificarConductor(".$fila->id.")'><i class='material-icons' style='font-size: 24px;'>edit</i></button>";
                $accion.= "<button class='btn btn-danger btn-link btn-sm' type='button' data-original-title='Eliminar Registro' onClick='ELiminarConductor(".$fila->id.")'><i class='material-icons' style='font-size: 24px;'>close</i></button>";
                return $accion;
            })
            ->addColumn('unidades', function($fila){
                $unidades = $fila->unidades;
                $listadoUnidades = array();
                foreach ($unidades as $unidad) {
                    if(!in_array($unidad->numero,$listadoUnidades)){
                        array_push($listadoUnidades,$unidad->numero);
                    }
                }
                return $listadoUnidades;
            })
            ->editColumn('nombre',function($fila){
                $nombre = $fila->nombre.' '.$fila->primer_apellido. ' '.$fila->segundo_apellido;
                return $nombre;
            })
            ->rawColumns(['action','nombre','unidades'])
            ->make(true);
            return $tabla;
        }catch(Exception $e){
            return response()->json($e,501);
        }
    }

    public function saveDoc(Request $request)
    {
        $id = $request->idConductor;
        $listadoArchivos = Documento::where('conductor_id',$id)->get();
        if($request->hasFile('fotoPersona')){
            $this->guardar_archivo($request->file('fotoPersona'), $id, 'foto_persona',$listadoArchivos);
        }
        if($request->hasFile('fotoElector')){
            $this->guardar_archivo($request->file('fotoElector'), $id, 'foto_elector',$listadoArchivos);
        }
        if($request->hasFile('fotoLicencia')){
            $this->guardar_archivo($request->file('fotoLicencia'), $id, 'foto_licencia',$listadoArchivos);
        }
        if($request->hasFile('fotoElectorReverso')){
            $this->guardar_archivo($request->file('fotoElectorReverso'), $id, 'foto_elector_reverso',$listadoArchivos);
        }
        if($request->hasFile('fotoLicenciaReverso')){
            $this->guardar_archivo($request->file('fotoLicenciaReverso'), $id, 'foto_licencia_reverso',$listadoArchivos);
        }
    }

    private function guardar_archivo($file, $id, $nombreDoc,$listadoArchivos=null)
    {
        $nombre = $id."_".$nombreDoc.".".$file->getClientOriginalExtension();
        $nombreSinExtension = $id."_".$nombreDoc;
        if($listadoArchivos!=null){
            //Si es un update borra el archivo anterior
            foreach ($listadoArchivos as $archivo) {
                $nombreNuevo = explode(".",$archivo->nombre_documento);
                $nuevoSinExtencion = $nombreNuevo[0];
                if($nuevoSinExtencion == $nombreSinExtension){
                    \Storage::delete($archivo->nombre_documento);
                    $archivo->delete();
                }
            }
        }   
        \Storage::disk('public')->put($nombre,  \File::get($file));
        $documento = new Documento();
        $documento->nombre_documento = $nombre;
        $documento->conductor_id = $id;
        $documento->save();
    }
}
