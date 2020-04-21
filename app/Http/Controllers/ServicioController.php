<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Servicio;
use App\Http\Models\Cliente;
use App\Http\Models\Unidad;
use App\Http\Models\Direccion;
use App\Http\Models\Cat_municipio;
use App\Http\Models\Cat_localidad;
use App\Http\Models\Cat_colonia;
use App\Http\Models\Horario;
use DataTables;
use DB;

class ServicioController extends Controller
{
    public function listRecords(){  
        $listadoRegistros = Servicio::with('cliente','direccion.colonia','user', 'direccion.localidad')->get();
        
        $tabla = Datatables::of($listadoRegistros)
            ->addColumn('action',function($fila){
                $accion = null;
                $accion.= "<button class='btn btn-primary btn-link btn-sm' type='button' data-original-title='Editar servicio' onClick='editarServicio(".$fila->id.")'><i class='material-icons'>edit</i></button>";
                $accion.= "<button class='btn btn-danger btn-link btn-sm' type='button' data-original-title='Eliminar servicio' onClick='eliminarServicio(".$fila->id.")'><i class='material-icons'>close</i></button>";
                return $accion;
            })
            ->addColumn('direccionCompleta',function($fila){
                $direccionCompleta = $fila['direccion']->calle.', Col. '.$fila['direccion']['colonia']->asentamiento. ', '.$fila['direccion']['localidad']->nombre;
                return $direccionCompleta;
            })
            ->rawColumns(['action','direccionCompleta'])
            ->make(true);   
        return $tabla;
    }

    public function create(Request $request){
        $cliente = null;
        $direccion = null;
        if($request->idRegistro){
            $servicio = Servicio::find($request->idRegistro);
        }else{
            $servicio = new Servicio();
        }
        try{
            DB::beginTransaction();
            
            if($request->personaSelect !=null || $request->idCliente !=null ){
                $cliente = ($request->personaSelect)? Cliente::find($request->personaSelect) : Cliente::find($request->idCliente);
                $servicio->cliente_id = ($request->personaSelect)? $request->personaSelect : $request->idCliente;
            }else{
                $cliente = new Cliente();
                $cliente->nombre = $request->persona;
                $cliente->telefono_fijo = ($request->telefono)? $request->telefono : '';
                $cliente->celular = ($request->celular)? $request->celular : '';
                $cliente->save();
                $servicio->cliente_id = $cliente->id;
            }
            // dd($servicio);
            if($request->direccionSelect !=null){
                $servicio->direccion_id = $request->direccionSelect;
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
                    $cat_colonia->save();
                    $direccion->colonia_id = $cat_colonia->id;
                }
                
                $direccion->referencia = ($request->referencia)? $request->referencia : '';
                $direccion->cliente_id = $cliente->id;
                $direccion->entre_calles = ($request->entre_calles)? $request->entre_calles : '';
                $direccion->calle = $request->calle;
                $direccion->save();
                $servicio->direccion_id = $direccion->id;
            }
            $servicio->user_id = $request->idUser;
            $servicio->save();

            $this->guardarHorario($request, $servicio->id);
            
            DB::commit();
            return response()->json($request,201);
        }catch (\PDOException $e) {
            dd($e);
            DB::rollBack();
            return response()->json($e,500);
        }

    }

    public function guardarHorario($request, $idServicio){
        $listadoHorarios = Servicio::where('servicio_id',$idServici)->get();
        foreach ($listadoHorarios as $horario) {
            $horario->delete();
        }
        if($request->lunes){
            $horario = new Horario();
            $horario->dia = 'Lunes';
            $horario->hora = $request->lunes;
            $horario->servicio_id = $idServicio;
            $horario->save();
        }
        if($request->martes){
            $horario = new Horario();
            $horario->dia = 'Martes';
            $horario->hora = $request->martes;
            $horario->servicio_id = $idServicio;
            $horario->save();
        }
        if($request->miercoles){
            $horario = new Horario();
            $horario->dia = 'Miercoles';
            $horario->hora = $request->miercoles;
            $horario->servicio_id = $idServicio;
            $horario->save();
        }
        if($request->jueves){
            $horario = new Horario();
            $horario->dia = 'Jueves';
            $horario->hora = $request->jueves;
            $horario->servicio_id = $idServicio;
            $horario->save();
        }
        if($request->viernes){
            $horario = new Horario();
            $horario->dia = 'Viernes';
            $horario->hora = $request->viernes;
            $horario->servicio_id = $idServicio;
            $horario->save();
        }
        if($request->sabado){
            $horario = new Horario();
            $horario->dia = 'Sábado';
            $horario->hora = $request->sabado;
            $horario->servicio_id = $idServicio;
            $horario->save();
        }
        if($request->domingo){
            $horario = new Horario();
            $horario->dia = 'Domingo';
            $horario->hora = $request->domingo;
            $horario->registro_id = $idServicio;
            $horario->save();
        }
        
    }

    public function show($idServicio)
    {
        $servicio = Servicio::with('horarios')->where('id',$idServicio)->first();
        $clientes = Cliente::find($servicio->cliente_id);
        $direcciones = Direccion::where('cliente_id',$servicio->cliente_id)->get();
        $unidades = Unidad::all();
        $arreglo = [];
        array_push($arreglo,$servicio,$clientes,$direcciones,$unidades);
        return response()->json($arreglo,201);
    }

    public function delete(Request $request)
    {
        $servicio = Servicio::find($request->idServicio);
        $servicio->delete();
        return response()->json("Borrado exitoso!",201);
    }
}
