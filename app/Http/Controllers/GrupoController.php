<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrupoCrearGrupoFormRequest;
use App\Models\Grupo;
use App\Models\Integrante;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function misGrupos()
    {
        $gruposEnLosQueParticipo = Grupo::with("integrantesDelGrupo.exclusionesDelIntegrante")
            ->WhereHas("integrantesDelGrupo", function($query){
                $query->where("usuario", auth()->user()->id);
            });

        $gruposSoyPropietario = auth()->user()->misGrupos()->with("integrantesDelGrupo.exclusionesDelIntegrante")
            ->union($gruposEnLosQueParticipo)->get();

        return response()->json(
            $gruposSoyPropietario,
            200
        );
    }

    public function crearGrupo(GrupoCrearGrupoFormRequest $request)
    {
        $grupo = new Grupo($request->all());
        $grupo->administrador = auth()->user()->id;
        $grupo->save();

        $integrante = new Integrante();
        $integrante->nombre = auth()->user()->name;
        $integrante->correo = auth()->user()->email;
        $integrante->grupo = $grupo->id;
        $integrante->usuario = auth()->user()->id;
        $integrante->confirmado = true;
        $integrante->save();

        $grupo->load("integrantesDelGrupo")->refresh();

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

    public function reiniciarGrupo(Grupo $grupo, Request $request)
    {
        //1. Compruebo si el admin quiere quitar a los participantes
        if($request->get("reiniciar_participantes")){
            $grupo->integrantesDelGrupo()->delete();
        }

        //2. Ahora marco el grupo como no asignado
        $grupo->integrantes_asignados = false;
        $grupo->fecha_autoasignacion = null;
        $grupo->save();

        $grupo->load("integrantesDelGrupo")
            ->refresh();

        return response()->json($grupo, 200);
    }
}
