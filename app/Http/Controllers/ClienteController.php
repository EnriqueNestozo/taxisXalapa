<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Cliente;
use DataTables;

class ClienteController extends Controller
{
    public function __construct(){
        // $this->middleware('client-credential');
    }

    public function create(Request $request)
    {
        $cliente = Cliente::create($request->all());
        return response()->json($cliente,201);
    }

    public function update(Request $request)
    {
        $cliente = Cliente::find($request->id);
        $cliente->update($request->all());
        return response()->json($cliente,201);
    }

    public function delete(Request $request)
    {
        $cliente = Cliente::find($request->id);
        $cliente->delete();
        return response()->json(null,204);
    }

    public function show($idCliente)
    {
        $cliente = Cliente::find($idCliente);
        return response()->json($cliente,201);
    }

    public function listClients()
    {
        $listadoClientes = Cliente::all();
        $tabla = Datatables::of($listadoClientes)
                    ->addColumn('action',function($fila){
                        $accion = null;
                        $accion.= "<button class='btn btn-primary btn-link btn-sm' type='button' data-original-title='Editar Usuario' onClick='editarCliente(".$fila->id.")'><i class='material-icons'>edit</i></button>";
                        $accion.= "<button class='btn btn-danger btn-link btn-sm' type='button' data-original-title='Eliminar Usuario' onClick='eliminarCliente(".$fila->id.")'><i class='material-icons'>close</i></button>";
                        return $accion;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        return $tabla;
        // return response()->json($listadoClientes,201);
    }

    public function getClientes()
    {
        $listadoClientes = Cliente::all();
        return response()->json($listadoClientes,201);
    }

}
