<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrupoCrearGrupoFormRequest;
use App\Models\Grupo;

class GrupoController extends Controller
{
    public function misGrupos()
    {
        $misGrupos = Grupo::with("integrantesDelGrupo")
            ->where("administrador", auth()->user()->id)
            ->get();

        return response()->json(
            $misGrupos,
            200
        );
    }

    public function crearGrupo(GrupoCrearGrupoFormRequest $request)
    {
        $grupo = new Grupo($request->all());
        $grupo->administrador = auth()->user()->id;
        $grupo->save();

        return response()->json(
            $grupo,
            200
        );
    }

    public function editarGrupo(Grupo $grupo, GrupoCrearGrupoFormRequest $request)
    {
        $grupo->update($request->all());

        return response()->json(
            $grupo,
            200
        );
    }

    public function eliminarGrupo(Grupo $grupo)
    {
        $grupo->delete();

        return response()->json(
            [],
            200
        );
    }
}
