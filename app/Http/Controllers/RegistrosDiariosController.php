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
use Illuminate\Support\Facades\Config;
use DataTables;
use DB;
use Carbon\Carbon;

class RegistrosDiariosController extends Controller
{
    public function listRecords($tipoRegistro){  
        $listadoRegistros = RegistroDiario::with('cliente','unidad','direccion.colonia','user', 'direccion.localidad', 'direccionDestino.colonia', 'direccionDestino.localidad')->where('tipo_registro',$tipoRegistro)->whereDate('created_at',Carbon::today())->withTrashed()->get();
        // dd($listadoRegistros->toArray());
        $tabla = Datatables::of($listadoRegistros)
            ->editColumn('estatus',function($fila){
                $estatus = null;
                if($fila['estatus']==Config::get("constantes.ESTATUS.LISTO")){
                    $estatus= '<span class="badge badge-info">Listo</span>';
                }
                if($fila['estatus']==Config::get("constantes.ESTATUS.SIN_UNIDAD")){
                    $estatus= '<span class="badge badge-warning">Sin unidad</span>';
                }
                if($fila['estatus']==Config::get("constantes.ESTATUS.CANCELADO")){
                    $estatus= '<span class="badge" style="background-color:red; color:white">Cancelado</span>';
                }
                return $estatus;
            })
            ->addColumn('action',function($fila){
                $accion = null;
                if($fila['estatus']!=Config::get("constantes.ESTATUS.CANCELADO")){
                    $accion.= "<button class='btn btn-primary btn-link btn-sm' type='button' data-original-title='Editar Registro' onClick='editarRegistro(".$fila->id.")'><i class='material-icons'>edit</i></button>";
                    $accion.= "<button class='btn btn-danger btn-link btn-sm' type='button' data-original-title='Eliminar Registro' onClick='eliminarRegistro(".$fila->id.")'><i class='material-icons'>close</i></button>";
                }
                if($fila['direccion_destino_id']==null){
                    $accion.= "<button class='btn btn-primary btn-link btn-sm' type='button' data-original-title='Agregar destino' onClick='agregarDestino(".$fila->id.",".$fila->cliente_id.")'><i class='material-icons'>location_on
                    </i></button>"; 
                }else{
                    $accion.= "<button class='btn btn-primary btn-link btn-sm' type='button' data-original-title='Agregar destino' onClick='mostrarDestino(".$fila.")'><i class='material-icons'>location_off
                    </i></button>"; 
                }
                return $accion;
            })
            ->addColumn('direccionCompleta',function($fila){
                $direccionCompleta = $fila['direccion']->calle.', Col. '.$fila['direccion']['colonia']->asentamiento. ', '.$fila['direccion']['localidad']->nombre;
                return $direccionCompleta;
            })
            ->editColumn('direccionDestino',function($fila){
                $direccionCompletaDestino = null;
                if($fila['direccionDestino']){
                    $direccionCompletaDestino = $fila['direccionDestino']->calle.' Col. '.$fila['direccionDestino']['colonia']->asentamiento.', '.$fila['direccionDestino']['localidad']->nombre;
                }else{
                    $direccionCompletaDestino = '<span class="badge" style="background-color:purple; color:white">Sin destino</span>';
                }
                return $direccionCompletaDestino;
            })
            ->rawColumns(['estatus','action','direccionCompleta','direccionDestino'])
            ->make(true);
        return $tabla;
    }

    public function create(Request $request){
        $cliente = null;
        $direccion = null;
        if($request->idRegistro){
            $registroDiario = RegistroDiario::find($request->idRegistro);
        }else{
            $registroDiario = new RegistroDiario();
        }
        try{
            DB::beginTransaction();
            $registroDiario->tipo_registro=($request->tipoRegistro)? ($request->tipoRegistro) : '0';
            $registroDiario->hora = $request->hora;
            $registroDiario->servicio_id= ($request->idServicio)? $request->idServicio : null;
            if($request->personaSelect !=null || $request->idCliente !=null ){
                $cliente = ($request->personaSelect)? Cliente::find($request->personaSelect) : Cliente::find($request->idCliente);
                $registroDiario->cliente_id = ($request->personaSelect)? $request->personaSelect : $request->idCliente;
            }else{
                $cliente = new Cliente();
                $cliente->nombre = $request->persona;
                $cliente->telefono_fijo = ($request->telefono)? $request->telefono : '';
                $cliente->celular = ($request->celular)? $request->celular : '';
                $cliente->save();
                $registroDiario->cliente_id = $cliente->id;
            }
            // dd($registroDiario);
            if($request->direccionSelect !=null){
                $registroDiario->direccion_id = $request->direccionSelect;
            }else{
                $direccion = new Direccion();
                
                $direccion->calle = $request->direccion;
                $direccion->estado_id = '30';
                if($request->municipioSelect){
                    $municipio = Cat_municipio::where('cve_mun',$request->municipioSelect)->where('cve_ent',30)->first();
                    $direccion->municipio_id = $municipio->id;
                }else{
                    $cat_municipio = new Cat_municipio();
                    $cat_municipio->cve_ent = '30';
                    $ultimoMun = Cat_municipio::latest('cve_mun')->where('cve_ent',30)->first();
                    $cat_municipio->cve_mun = $ultimoMun->cve_mun + 1;
                    $cat_municipio->nombre = $request->municipio;
                    $cat_municipio->save();
                    $municipio = $cat_municipio;
                    $direccion->municipio_id = $municipio->id;
                }
                if($request->localidadSelect){
                    $localidad = Cat_localidad::where('cve_mun',$municipio->cve_mun)->where('cve_ent',30)->first();
                    $direccion->localidad_id = $localidad->id;
                }else{
                    $cat_localidad = new Cat_localidad();
                    $cat_localidad->cve_ent = '30';
                    $cat_localidad->cve_mun = ($request->municipioSelect)? $request->municipioSelect : $cat_municipio->id;
                    $ultimaLoc = Cat_localidad::latest('cve_loc')->where('cve_ent',30)->first();
                    $cat_localidad->cve_loc = $ultimaLoc->cve_loc + 1;
                    $cat_localidad->nombre = $request->localidad;
                    $cat_localidad->lat_decimal = '00.0000';
                    $cat_localidad->lon_decimal = '00.0000';
                    $cat_localidad->altitud = '0';
                    $cat_localidad->save();
                    $direccion->localidad_id = $cat_localidad->id;
                }
                if($request->coloniaSelect){
                    $direccion->colonia_id = $request->coloniaSelect;
                }else{
                    $cat_colonia = new Cat_colonia();
                    $cat_colonia->cve_ent = '30';
                    $cat_colonia->cve_mun = ($request->municipioSelect)? $request->municipioSelect : $cat_municipio->id;
                    $datos_localidad = ($request->localidadSelect)? $localidad : Cat_localidad::find($cat_localidad->id);
                    $cat_colonia->ciudad = $datos_localidad->nombre;
                    $cat_colonia->zona = 'Urbano';
                    $cat_colonia->asentamiento = $request->colonia;
                    $cat_colonia->tipo = 'Colonia';
                    $cat_colonia->codigo_postal = '91000';
                    $cat_colonia->save();
                    $direccion->colonia_id = $cat_colonia->id;
                }
                
                $direccion->referencia = ($request->referencia)? $request->referencia : '';
                $direccion->cliente_id = $cliente->id;
                $direccion->entre_calles = ($request->entre_calles)? $request->entre_calles : '';
                $direccion->calle = $request->calle;
                $direccion->save();
                $registroDiario->direccion_id = $direccion->id;
            }
            $registroDiario->unidad_id = $request->clave;
            $registroDiario->estatus = ($request->clave)? Config::get("constantes.ESTATUS.LISTO") : Config::get("constantes.ESTATUS.SIN_UNIDAD");
            $registroDiario->user_id = $request->idUser;
            $registroDiario->save();

            if($request->isRecurrente=='on'){
                $this->guardarHorario($request, $registroDiario->id);
            }
            
            DB::commit();
            return response()->json($registroDiario,201);
        }catch (\PDOException $e) {
            dd($e);
            DB::rollBack();
            return response()->json($e,500);
        }
        //si hay destino
        
        
    }

    public function createDestino(Request $request){
        $cliente = null;
        $direccion = null;
        try{
            DB::beginTransaction();
            $registroDiario = RegistroDiario::find($request->idRegistro);

            
            // $registroDiario->hora = $request->hora;
            // $registroDiario->servicio_id= ($request->idServicio)? $request->idServicio : null;
            // if($request->personaSelect !=null || $request->idCliente !=null ){
            //     $cliente = ($request->personaSelect)? Cliente::find($request->personaSelect) : Cliente::find($request->idCliente);
            //     $registroDiario->cliente_id = ($request->personaSelect)? $request->personaSelect : $request->idCliente;
            // }else{
            //     $cliente = new Cliente();
            //     $cliente->nombre = $request->persona;
            //     $cliente->telefono_fijo = ($request->telefono)? $request->telefono : '';
            //     $cliente->celular = ($request->celular)? $request->celular : '';
            //     $cliente->save();
            //     $registroDiario->cliente_id = $cliente->id;
            // }
            // dd($registroDiario);
            if($request->direccionDestinoSelect !=null){
                $registroDiario->direccion_destino_id = $request->direccionDestinoSelect;
            }else{
                $direccion = new Direccion();
                
                $direccion->calle = $request->calleDestino;
                $direccion->estado_id = '30';
                if($request->municipioDestinoSelect){
                    $municipio = Cat_municipio::where('cve_mun',$request->municipioDestinoSelect)->where('cve_ent',30)->first();
                    $direccion->municipio_id = $municipio->id;
                }else{
                    $cat_municipio = new Cat_municipio();
                    $cat_municipio->cve_ent = '30';
                    $ultimoMun = Cat_municipio::latest('cve_mun')->where('cve_ent',30)->first();
                    $cat_municipio->cve_mun = $ultimoMun->cve_mun + 1;
                    $cat_municipio->nombre = $request->municipioDestino;
                    $cat_municipio->save();
                    $municipio = $cat_municipio;
                    $direccion->municipio_id = $municipio->id;
                }
                if($request->localidadDestinoSelect){
                    $localidad = Cat_localidad::where('cve_mun',$municipio->cve_mun)->where('cve_ent',30)->first();
                    $direccion->localidad_id = $localidad->id;
                }else{
                    $cat_localidad = new Cat_localidad();
                    $cat_localidad->cve_ent = '30';
                    $cat_localidad->cve_mun = ($request->municipioDestinoSelect)? $request->municipioDestinoSelect : $cat_municipio->id;
                    $ultimaLoc = Cat_localidad::latest('cve_loc')->where('cve_ent',30)->first();
                    $cat_localidad->cve_loc = $ultimaLoc->cve_loc + 1;
                    $cat_localidad->nombre = $request->localidadDestino;
                    $cat_localidad->lat_decimal = '00.0000';
                    $cat_localidad->lon_decimal = '00.0000';
                    $cat_localidad->altitud = '0';
                    $cat_localidad->save();
                    $direccion->localidad_id = $cat_localidad->id;
                }
                if($request->coloniaDestinoSelect){
                    $direccion->colonia_id = $request->coloniaDestinoSelect;
                }else{
                    $cat_colonia = new Cat_colonia();
                    $cat_colonia->cve_ent = '30';
                    $cat_colonia->cve_mun = ($request->municipioDestinoSelect)? $request->municipioDestinoSelect : $cat_municipio->id;
                    $datos_localidad = ($request->localidadDestinoSelect)? $localidad : Cat_localidad::find($cat_localidad->id);
                    $cat_colonia->ciudad = $datos_localidad->nombre;
                    $cat_colonia->zona = 'Urbano';
                    $cat_colonia->asentamiento = $request->coloniaDestino;
                    $cat_colonia->tipo = 'Colonia';
                    $cat_colonia->codigo_postal = '91000';
                    $cat_colonia->save();
                    $direccion->colonia_id = $cat_colonia->id;
                }
                
                $direccion->referencia = ($request->referenciaDestino)? $request->referenciaDestino : '';
                $direccion->cliente_id = $registroDiario->cliente_id;
                $direccion->entre_calles = ($request->entre_callesDestino)? $request->entre_callesDestino : '';
                $direccion->calle = $request->calleDestino;
                $direccion->es_destino = 1;
                $direccion->save();
                $registroDiario->direccion_destino_id = $direccion->id;
            }
            $registroDiario->save();

            if($request->isRecurrente=='on'){
                $this->guardarHorario($request, $registroDiario->id);
            }
            
            DB::commit();
            return response()->json($request,201);
        }catch (\PDOException $e) {
            // dd($e);
            DB::rollBack();
            return response()->json($e,500);
        }
    }

    public function deleteDestino(Request $request){
        try{
            DB::beginTransaction();
            $registroDiario = RegistroDiario::find($request->idRegistro);
            $registroDiario->direccion_destino_id = null;
            $registroDiario->save();
            DB::commit();
            return response()->json($registroDiario,201);
        }catch (\PDOException $e) {
            DB::rollBack();
            return response()->json($e,500);
        }
    }

    public function show($idRegistro)
    {
        $registro = RegistroDiario::find($idRegistro);
        $clientes = Cliente::find($registro->cliente_id);
        $direcciones = Direccion::where('cliente_id',$registro->cliente_id)->get();
        $unidades = Unidad::all();
        $arreglo = [];
        array_push($arreglo,$registro,$clientes,$direcciones,$unidades);
        return response()->json($arreglo,201);
    }

    public function delete(Request $request)
    {
        $registro = RegistroDiario::find($request->idRegistro);
        // $registro->delete();
        $registro->estatus = Config::get("constantes.ESTATUS.CANCELADO");
        $registro->save();
        return response()->json("Borrado exitoso!",201);
    }
}
