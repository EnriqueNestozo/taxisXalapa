<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Unidad;

class UnidadController extends Controller
{
    public function __construct(){
        // $this->middleware('client-credential');
    }

    public function create(Request $request)
    {
        $unidad = Unidad::create($request->all());
        return response()->json($unidad,201);
    }

    public function update(Request $request)
    {
        $unidad = Unidad::find($request->id);
        $unidad->update($request->all());
        return response()->json($unidad,201);
    }

    public function delete(Request $request)
    {
        $unidad = Unidad::find($request->id);
        $unidad->delete();
        return response()->json(null,204);
    }

    public function show($idUnidad)
    {
        $unidad = Unidad::find($idUnidad);
        return response()->json($unidad,201);
    }

    public function listClients()
    {
        $listadounidades = Unidad::all();
        return response()->json($listadounidades,201);
    }
}
