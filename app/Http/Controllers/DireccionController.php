<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Direccion;

class DireccionController extends Controller
{
    public function __construct(){
        // $this->middleware('client-credential');
    }

    public function create(Request $request)
    {
        $direccion = Direccion::create($request->all());
        return response()->json($direccion,201);
    }

    public function update(Request $request)
    {
        $direccion = Direccion::find($request->id);
        $direccion->update($request->all());
        return response()->json($direccion,201);
    }

    public function delete(Request $request)
    {
        $direccion = Direccion::find($request->id);
        $direccion->delete();
        return response()->json(null,204);
    }

    public function show($idDireccion)
    {
        $direccion = Direccion::find($idDireccion);
        return response()->json($direccion,201);
    }

    public function listClients($idCliente)
    {
        $listadoDirecciones = Direccion::all();
        return response()->json($listadoDirecciones,201);
    }
}
