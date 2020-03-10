<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Conductor;

class ConductorController extends Controller
{
    public function __construct(){
        // $this->middleware('client-credential');
    }

    public function create(Request $request)
    {
        $conductor = Conductor::create($request->all());
        return response()->json($conductor,201);
    }

    public function update(Request $request)
    {
        $conductor = Conductor::find($request->id);
        $conductor->update($request->all());
        return response()->json($conductor,201);
    }

    public function delete(Request $request)
    {
        $conductor = Conductor::find($request->id);
        $conductor->delete();
        return response()->json(null,204);
    }

    public function show($idConductor)
    {
        $conductor = Conductor::find($idConductor);
        return response()->json($conductor,201);
    }

    public function listConductores()
    {
        $listadoconductores = Conductor::all();
        return response()->json($listadoconductores,201);
    }
}
