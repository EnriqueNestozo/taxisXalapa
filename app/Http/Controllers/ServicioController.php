<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Servicio;
use App\Http\Models\Cliente;
use App\Http\Models\Unidad;
use App\Http\Models\RegistroDiario;
use App\Http\Models\Direccion;
use App\Http\Models\Cat_municipio;
use App\Http\Models\Cat_localidad;
use App\Http\Models\Cat_colonia;
use App\Http\Models\Horario;
use Carbon\Carbon;
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
                $direccionCompleta = ($fila['direccion']->calle)? 'Calle '.$fila['direccion']->calle.', ' : '';
                $direccionCompleta .= ($fila['direccion']['colonia'])? 'Col. '.$fila['direccion']['colonia']->asentamiento.', ' : '';
                $direccionCompleta .= $fila['direccion']['localidad']->nombre;
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
            
            if($request->busquedaSelect !=null || $request->idCliente !=null ){
                $cliente = ($request->busquedaSelect)? Cliente::find($request->busquedaSelect) : Cliente::find($request->idCliente);
                $servicio->cliente_id = ($request->busquedaSelect)? $request->busquedaSelect : $request->idCliente;
            }else{
                $cliente = new Cliente();
                $cliente->nombre = $request->persona;
                $cliente->telefono_fijo = ($request->telefono)? str_replace('-', '', $request->telefono) : '';
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
                    if($request->colonia){
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
                }
                
                $direccion->referencia = ($request->referencia)? $request->referencia : '';
                $direccion->cliente_id = $cliente->id;
                $direccion->entre_calles = ($request->entre_calles)? $request->entre_calles : '';
                $direccion->calle = $request->calle;
                $direccion->save();
                $servicio->direccion_id = $direccion->id;
            }
            $servicio->user_id = $request->idUser;
            $servicio->unidad_id = $request->clave;
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
        $listadoHorarios = Horario::where('servicio_id',$idServicio)->get();
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
            $horario->servicio_id = $idServicio;
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

    public function showWithCurrentScheedule($idServicio)
    {
        $fecha =  getdate();
        $date = Carbon::now();
        $date2 = Carbon::now();
        $daysSpanish = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miercoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sabado',
            7 => 'Domingo',
        ];
        $weekday = $daysSpanish[$fecha['wday']];
        $actualHour = date_format($date,"H:i:s");
        $dateAfter = $date->addHour();
        $toHour = date_format($dateAfter,"H:i:s");
        $servicio = Servicio::with(['horarios'=>function($query) use($weekday,$actualHour,$toHour){
            //TRAE SOLO EL HORARIO DEL DÍA Y HORA PROXIMA
            $query->where('dia',$weekday);
            $query->whereBetween('hora', [$actualHour,$toHour]);
        }])->where('id',$idServicio)->first();
        $clientes = Cliente::find($servicio->cliente_id);
        $direcciones = Direccion::with('municipio','localidad','colonia')->where('cliente_id',$servicio->cliente_id)->get();
        $unidades = Unidad::all();
        $arreglo = [];
        array_push($arreglo,$servicio,$clientes,$direcciones,$unidades);
        return response()->json($arreglo,201);
    }

    /*
        Elimina el servicio completo
    */
    public function delete(Request $request)
    {
        $servicio = Servicio::find($request->idServicio);
        $servicio->delete();
        return response()->json("Borrado exitoso!",201);
    }

    /*
        Cancela el servicio del día
    */
    public function cancelarServicio(Request $request){
        $cliente = null;
        $direccion = null;
        $registroDiario = new RegistroDiario();

        try{
            DB::beginTransaction();
            
            $fecha =  getdate();
            $date = Carbon::now();
            $date2 = Carbon::now();
            $daysSpanish = [
                1 => 'Lunes',
                2 => 'Martes',
                3 => 'Miercoles',
                4 => 'Jueves',
                5 => 'Viernes',
                6 => 'Sabado',
                7 => 'Domingo',
            ];
            $weekday = $daysSpanish[$fecha['wday']];
            $actualHour = date_format($date,"H:i:s");
            $dateAfter = $date->addHour();
            $toHour = date_format($dateAfter,"H:i:s");
            $servicio = Servicio::with(['horarios'=>function($query) use($weekday,$actualHour,$toHour){
                //TRAE SOLO EL HORARIO DEL DÍA Y HORA PROXIMA
                $query->where('dia',$weekday);
                $query->whereBetween('hora', [$actualHour,$toHour]);
            }])->where('id',$request->idServicio)->first();
            $registroDiario->hora = $servicio->horarios[0]->hora;
            $registroDiario->cliente_id = $servicio->cliente_id;
            $registroDiario->direccion_id = $servicio->direccion_id;
            $registroDiario->unidad_id = ($servicio->unidad_id)? $servicio->unidad_id : null;
            $registroDiario->estatus = 2;
            $registroDiario->user_id = $servicio->user_id;
            $registroDiario->tipo_registro='1';
            $registroDiario->servicio_id=$request->idServicio;
            $registroDiario->save();

            if($request->isRecurrente=='on'){
                $this->guardarHorario($request, $registroDiario->id);
            }
            
            DB::commit();
            return response()->json($request,201);
        }catch (\PDOException $e) {
            dd($e);
            DB::rollBack();
            return response()->json($e,500);
        }
    }

    //Obtiene el numero de servicios que hay pendientes para mostrar en la notificación
    public function numServiciosPendientes(){
        $listado = $this->obtenerListaServiciosPendientes();
        return count($listado);
    }

    //Obtiene la tabla de los servicios pendientes
    public function listaServiciosPendientes(){
        $listadoServicios = $this->obtenerListaServiciosPendientes();
        try{
            $tabla = Datatables::of($listadoServicios)
            ->addColumn('action',function($fila){
                $accion = null;
                $accion.= "<button class='btn btn-primary btn-link btn-sm' type='button' data-original-title='Generar registro' onClick='generarRegistro(".$fila->id.")'><i class='material-icons' style='font-size: 24px;'>assignment_turned_in</i></button>";
                $accion.= "<button class='btn btn-danger btn-link btn-sm' type='button' data-original-title='Cancelar Registro' onClick='cancelarRegistro(".$fila->id.")'><i class='material-icons' style='font-size: 24px;'    >close</i></button>";
                return $accion;
            })
            ->addColumn('direccionCompleta',function($fila){
                $direccionCompleta = ($fila['direccion']->calle)? 'Calle '.$fila['direccion']->calle.', ' : '';
                $direccionCompleta .= ($fila['direccion']['colonia'])? 'Col. '.$fila['direccion']['colonia']->asentamiento. ', ' : '';
                $direccionCompleta .= $fila['direccion']['localidad']->nombre;
                return $direccionCompleta;
            })
            ->rawColumns(['action','direccionCompleta'])
            ->make(true);

            return $tabla;
        }catch(Exception $e){
            return $e;
        }
        
    }

    public function obtenerListaServiciosPendientes(){
        $fecha =  getdate();
        $date = Carbon::now();
        $date2 = Carbon::now();
        $daysSpanish = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miercoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sabado',
            0 => 'Domingo',
        ];
        $weekday = $daysSpanish[$fecha['wday']];
        $actualHour = date_format($date,"H:i:s");
        $dateAfter = $date->addMinutes(20);
        $toHour = date_format($dateAfter,"H:i:s");
        $actualDate = date_format($date2,"Y-m-d H:i:s");
        // $listadoServicios = Servicio::whereHas('horarios',function($query) use ($weekday){
        //     $query->where('dia',$weekday);
        // })->get();
        // $listadoServicios = Servicio::with(['horarios','registros'])->whereHas('horarios',function($query) use ($weekday,$actualHour,$toHour){
        //     $query->where('dia',$weekday);
        //     $query->whereBetween('hora', [$actualHour,$toHour]);
        // })->whereHas('registros',function($query) use ($actualDate,$actualHour,$toHour){
        //     $query->where('created_at','!=',$actualDate);
        //     $query->whereNotBetween('hora', [$actualHour,$toHour]);
        // })->orWhereDoesntHave('registros')
        // ->get(); 

        $listadoServicios = Servicio::with(['horarios'=>function($query) use($weekday,$actualHour,$toHour){
            //TRAE SOLO EL HORARIO DEL DÍA Y HORA PROXIMA
            $query->where('dia',$weekday);
            $query->whereBetween('hora', [$actualHour,$toHour]);
        },'direccion.colonia','direccion.localidad','cliente'])->where(function ($query) use($weekday,$actualHour,$toHour){
            //DONDE TENGA UN HORARIO EN DÍA Y HORA PROXIMA
            $query->whereHas('horarios',function($subquery) use ($weekday,$actualHour,$toHour){
                $subquery->where('dia',$weekday);
                $subquery->whereBetween('hora', [$actualHour,$toHour]);
            });
        })->where(function ($query) use($weekday,$actualHour,$toHour, $actualDate){
            //yA TIENE REGISTROS EL DÍA DE HOY?
            //DONDE TENGA REGISTROS CREADOS EN DÍAS PASADOS O DÍA ACTUAL PERO A DIFERENTE HORA O DE PLANO NO TENGA REGISTROS
            $query->whereDoesntHave('registros',function($subquery) use ($actualDate,$actualHour,$toHour){
                // $subquery->where(function ($subsubquery) use($actualHour,$toHour, $actualDate){
                //     //FALTA SECCIONAR EL CREATED AT PARA QUE SOLO CUENTE LA FECHA Y NO LA HORA
                // });
                $subquery->where('created_at','>=',date('Y-m-d').' 00:00:00');
                $subquery->whereBetween('hora', [$actualHour,$toHour]);
                // $subquery->orwhere(function ($subsubquery) use($actualHour,$toHour, $actualDate){
                //     $subsubquery->where('created_at','>',date('Y-m-d').' 00:00:00');
                // });
            })->orWhereDoesntHave('registros');
        })->get(); 
        return $listadoServicios;
    }

    // $subquery->where(function ($subsubquery) use($actualHour,$toHour, $actualDate){
    //     //FALTA SECCIONAR EL CREATED AT PARA QUE SOLO CUENTE LA FECHA Y NO LA HORA
    //     $subsubquery->where('created_at','<',date('Y-m-d').' 00:00:00');
    //     $subsubquery->orwhere(function ($subsubsubquery) use($actualHour,$toHour, $actualDate){
    //         $subsubsubquery->where('created_at','>',date('Y-m-d').' 00:00:00');
    //         $subsubsubquery->whereNotBetween('hora', [$actualHour,$toHour]);
    //     });
    // });
    // $subquery->orwhere(function ($subsubquery) use($actualHour,$toHour, $actualDate){
    //     $subsubquery->where('created_at','<',date('Y-m-d').' 00:00:00');
    //     $subsubquery->where('created_at','>',date('Y-m-d').' 00:00:00');
    //     $subsubquery->whereNotBetween('hora', [$actualHour,$toHour]);
    // });
}
