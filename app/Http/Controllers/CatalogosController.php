<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Cat_municipio;
use App\Http\Models\Cat_localidad;
use App\Http\Models\Cat_colonia;

class CatalogosController extends Controller
{
    public function __construct(){
        // $this->middleware('client-credential');
    }

    public function getMunicipios()
    {
        $municipios = Cat_municipio::select('cve_mun AS id','nombre AS text')->orderBy('nombre')->get()->toArray();
        $arreglo = [
            'id' =>'',
            'text'=>'Seleccione un municipio...',
        ];
        $municipios[0]=$arreglo;
        return response()->json($municipios);
    }

    public function getLocalidades($idMunicipio)
    {
        $localidades = Cat_localidad::select('cve_loc AS id','nombre AS text')->where('cve_mun',$idMunicipio)->where('cve_ent',30)->orderBy('nombre')->get()->toArray();
        $arreglo = [
            'id' =>'',
            'text'=>'Seleccione una localidad...',
        ];
        $localidades[0]=$arreglo;
        return response()->json($localidades);
    }

    public function getColonias($idMunicipio)
    {
        $colonias = Cat_colonia::select('id','asentamiento AS text')->where('cve_ent',30)->where('cve_mun',$idMunicipio)->orderBy('asentamiento')->get()->toArray();
        $arreglo = [
            'id' =>'',
            'text'=>'Seleccione una colonia...',
        ];
        $colonias[0]=$arreglo;
        return response()->json($colonias);
    }
}
