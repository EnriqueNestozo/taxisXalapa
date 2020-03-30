<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\RegistroDiario;
use App\Http\Models\Cliente;
use App\Http\Models\Unidad;
use App\Http\Models\Direccion;
use DataTables;
use DB;

class RegistrosDiariosController extends Controller
{
    public function listRecords(){  
        $listadoRegistros = RegistroDiario::with('cliente','unidad','direccion','user')->get();
        
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
            $registroDiario->hora = $request->hora;
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
                //OBSERVACION: DE MOMENTO SE GUARDA TODO EN CALLE, FALTA VER SI SE VA A SEPARAR COMO ESTA EN LA BD, si todo va en calle hay que hacer colonia y numero nullable
                $direccion->calle = $request->direccion;
                $direccion->referencia = ($request->referencia)? $request->referencia : '';
                $direccion->cliente_id = $cliente->id;  //AQUI TRUENA, porque el cliente
                $direccion->entre_calles = ($request->entre_calles)? $request->entre_calles : '';
                $direccion->save();
                $registroDiario->direccion_id = $direccion->id;
            }
            //Hay que hacer que pueda guardarse nulo en bd
            $registroDiario->unidad_id = $request->clave;
            $registroDiario->user_id = $request->idUser;
            $registroDiario->save();
            DB::commit();
            return response()->json($request,201);
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
        $registro->delete();
        return response()->json("Borrado exitoso!",201);
    }
}
