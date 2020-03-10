<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Cliente;

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
        return response()->json($listadoClientes,201);
    }

}
