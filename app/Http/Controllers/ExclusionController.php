<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Requests\StoreExclusionRequest;
use App\Models\Exclusion;
use App\Models\Grupo;

class ExclusionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Grupo $grupo, StoreExclusionRequest $request)
    {
        $response["code"] = 0;
        $response["data"] = [];

        //Primero comprobamos si la exclusión es viable
        $result = Helpers::generarAsignaciones($grupo->integrantesDelGrupo()->get("id")->toArray());

        if($result["code"] == 0){
            $exclusion = new Exclusion();
            //TODO: Crear middleware para comprobar que estas apuntado al grupo
            $exclusion->usuario_que_regala = $grupo->integrantesDelGrupo()->where("usuario", auth()->user()->id)->first()->id;
            $exclusion->usuario_excluido = $request->get("usuario_excluido");
            $exclusion->grupo = $grupo->id;
            $exclusion->save();

            $response["status"] = 200;
            $response["data"] = $exclusion;
        }
        else{
            $response["status"] = 400;
            $response["data"] = "La asignación no es posible";
        }

        return response()->json($response["data"], $response["status"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grupo $grupo, Exclusion $exclusion)
    {
        $exclusion->delete();

        return response()->json([], 200);
    }
}
