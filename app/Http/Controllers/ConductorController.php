<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Conductor;
use App\Http\Models\Documento;
use App\Http\Controllers\Storage;
use App\Http\Controllers\File;
use DB;

class ConductorController extends Controller
{
    public function __construct(){
        // $this->middleware('client-credential');
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {  
            $conductor = Conductor::create($request->all());
            $conductor->save();
            $request->request->add(['id_registro' => $conductor->id]);
            $this->saveDoc($request);
            DB::commit();
            return response()->json($conductor,201);
        }catch (\PDOException $e) {      
            DB::rollBack();
            dd($e);
            $succes = 'Fail'; 
            $folio = 'Intente de nuevo';       
            return response()->json($conductor,501);
        }
            
        
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

    public function saveDoc(Request $request)
    {
        // dd($request->all());
        $id = $request->id_registro;
        // dd('en el SaveDoc: ', $registro);
        
        $this->guardar_archivo($request->file('fotoPersona'), $id, 'foto_persona');
        $this->guardar_archivo($request->file('fotoElector'), $id, 'foto_elector');
        $this->guardar_archivo($request->file('fotoLicencia'), $id, 'foto_licencia');
        $this->guardar_archivo($request->file('fotoElectorReverso'), $id, 'foto_elector_reverso');
        $this->guardar_archivo($request->file('fotoLicenciaReverso'), $id, 'foto_licencia_reverso');
    }

    private function guardar_archivo($file, $id, $nombreDoc)
    {
        $nombre = $id."_".$nombreDoc.".".$file->getClientOriginalExtension();
        \Storage::disk('local')->put($nombre,  \File::get($file));
        
        $documento = new Documento();
        $documento->nombre_documento = $nombre;
        $documento->conductor_id = $id;
        $documento->save();
    }
}
