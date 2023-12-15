<?php

namespace App\Http\Controllers;

use App\Events\NuevoIntegranteCreado;
use App\Http\Requests\IntegranteCrearIntegranteFormRequest;
use App\Http\Requests\IntegranteCrearIntegrantesFormRequest;
use App\Models\Grupo;
use App\Models\Integrante;
use App\Models\User;

class IntegranteController extends Controller
{
    public function crearIntegrante(Grupo $grupo, IntegranteCrearIntegranteFormRequest $request)
    {
        $integrante = $this->crearIntegranteIndividual($grupo, $request->all());

        return response()->json(
            $integrante,
            200
        );
    }

    public function crearIntegrantes(Grupo $grupo, IntegranteCrearIntegrantesFormRequest $request)
    {
        $integrantes = [];

        foreach($request->integrantes as $integrante){
            $integranteAux = $this->crearIntegranteIndividual($grupo, $integrante);

            array_push($integrantes, $integranteAux);
        }

        return response()->json($integrantes, 200);
    }

    public function quitarIntegrante(Grupo $grupo, Integrante $integrante)
    {
        if($grupo->id != $integrante->grupo){
            return response()->json([], 400);
        }

        $integrante->delete();

        return response()->json([], 200);
    }

    public function getApuntarseGrupo(Grupo $grupo, string $hash)
    {
        if($grupo->hash != $hash){
            return "El enlace no es válido";
        }else{
            return view("integrantes.apuntarseIntegrante", compact("grupo"));
        }
    }

    public function postApuntarseGrupo(Grupo $grupo, $hash, IntegranteCrearIntegranteFormRequest $request)
    {
        if($grupo->hash != $hash)
        {
            return "La URL no es válida";
        }

        $this->crearIntegranteIndividual($grupo, $request->all());

        return view("integrantes.apuntarseIntegranteOk");
    }

    public function aceptarInvitacion(Grupo $grupo, string $hash)
    {
        $integrante = Integrante::where("grupo", $grupo->id)
            ->where("hash_confirmacion", $hash)
            ->firstOrFail();

        $integrante->confirmado = true;
        $integrante->save();

        return view("integrantes.invitacionAceptada");
    }

    public function realizarAsignaciones(Grupo $grupo)
    {
        //Primero eliminamos los integrantes que no hayan confirmado
        Integrante::where("confirmado", false)
            ->where("grupo", $grupo->id)
            ->delete();

        $integrantes = $grupo->integrantesDelGrupo;

        //Duplicamos el array y lo shuffleamos random
        $integrantes2 = $integrantes->shuffle();

        foreach($integrantes as $index => $integrante){
            $integrante->integrante_asignado = $integrantes2->get($index)->id;
            $integrante->save();
        }

        $grupo->integrantes_asignados = true;
        $grupo->save();

        return response()->json($integrantes, 200);
    }

    private function crearIntegranteIndividual(Grupo $grupo, array $request)
    {
        $integrante = new Integrante($request);
        $integrante->grupo = $grupo->id;

        //Compruebo si existe el correo registrado en la tabla de usuarios y lo asigno
        $user = User::where("email", $request["correo"])->first();

        if($user){
            $integrante->usuario = $user->id;
            $integrante->confirmado = true;
        }

        $integrante->save();
        $integrante->refresh();

        //Una vez guardado el integrante, creo el evento para enviar una notificación al correo del integrante
        NuevoIntegranteCreado::dispatch($grupo, $integrante, $integrante->hash_confirmacion);

        return $integrante;
    }
}
