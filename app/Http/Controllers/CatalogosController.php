<?php

namespace App\Http\Controllers;



class CatalogoController extends Controller
{
    public function __construct(){
        // $this->middleware('client-credential');
    }

    public function getMunicipios()
    {
        $municipios = Cat_municipio::where('')->get();
        return response()->json($municipios,201);
    }

    public function getLocalidades($idMunicipio)
    {
        $localidades = Cat_localidad::where('',$idMunicipio)->get();
        return response()->json($localidades,201);
    }

    public function getColonias($idLocalidad)
    {
        $colonias = Conductor::where('',$idLocalidad)->get();
        return response()->json($colonias,201);
    }
}
