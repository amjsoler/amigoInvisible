<?php

namespace App\Http\Controllers;

use App\Events\NuevoIntegranteCreado;
use App\Helpers\Helpers;
use App\Http\Requests\IntegranteCrearIntegranteFormRequest;
use App\Http\Requests\IntegranteCrearIntegrantesFormRequest;
use App\Models\Grupo;
use App\Models\Integrante;
use App\Models\User;
use App\Notifications\EnviarCorreoAsignacionIntegrante;
use App\Notifications\EnviarCorreoConfirmacionIntegranteNotification;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

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

    public function reenviarCorreoConfirmacion(Grupo $grupo, Integrante $integrante)
    {
        if($grupo->id != $integrante->grupo){
            return response()->json([], 400);
        }

        Notification::route('mail', $integrante->correo)
            ->notify(new EnviarCorreoConfirmacionIntegranteNotification($grupo, $integrante));

        return response()->json();
    }

    public function getApuntarseGrupo(Grupo $grupo, string $hash)
    {
        $response = array();

        if($grupo->hash != $hash){
            $response["code"] = -1;
        }else{
            $response["code"] = 0;
        }

        return view("integrantes.apuntarseIntegrante", compact("grupo"))->with("response", $response);
    }

    public function postApuntarseGrupo(Grupo $grupo, $hash, IntegranteCrearIntegranteFormRequest $request)
    {
        $response = [];

        if($grupo->hash != $hash)
        {
            $response["code"] = -1;
        }else{
            $this->crearIntegranteIndividual($grupo, $request->all());
            $response["code"] = 0;
        }

        return view("integrantes.apuntarseIntegranteOk", compact("response"));
    }

    public function aceptarInvitacion(Grupo $grupo, Integrante $integrante, string $hash)
    {
        $response["code"] = 0;

        try{

            if($grupo->id != $integrante->grupo){
                $response["code"] = -2;
            }

            $integrante = Integrante::where("id", $integrante->id)
                ->where("hash_confirmacion", $hash)
                ->firstOrFail();

            $integrante->confirmado = true;
            $integrante->save();
        }
        catch(Exception $e){
            $response["code"] = -1;
        }

        return view("integrantes.invitacionAceptada", compact("response"));
    }

    public function realizarAsignaciones(Grupo $grupo)
    {
        //Primero eliminamos los integrantes que no hayan confirmado
        Integrante::where("confirmado", false)
            ->where("grupo", $grupo->id)
            ->delete();

        $integrantes = $grupo->integrantesDelGrupo();

        //1. Primero saco mis asignaciones random
        $asignaciones = Helpers::generarAsignaciones($integrantes->get("id")->toArray());

        //2. Ahora recorro los integrantes y voy guardando las asociaciones
        $integrantes = $integrantes->get();

        foreach($integrantes as $integrante){
            $auxArray = array_filter($asignaciones, function($value) use ($integrante){
                 return $value["integrante"] == $integrante->id;
            });

            $auxArray = array_shift($auxArray);
            $integrante->integrante_asignado = $auxArray["integrante_asignado"];
            $integrante->save();

            //3. Mandamos correo con el integrante que le ha tocado al usuario
            Notification::route('mail', $integrante->correo)
                ->notify(new EnviarCorreoAsignacionIntegrante($grupo->nombre, $auxArray["nombre_integrante_asignado"]));
        }

        $grupo->integrantes_asignados = true;
        $grupo->save();

        return response()->json();
    }

    private function crearIntegranteIndividual(Grupo $grupo, array $request)
    {
        $integrante = new Integrante($request);
        $integrante->grupo = $grupo->id;
        $integrante->hash_confirmacion = str_replace("/", "", Hash::make(now()));

        //Compruebo si existe el correo registrado en la tabla de usuarios y lo asigno
        $user = User::where("email", $request["correo"])->first();

        if($user){
            $integrante->usuario = $user->id;
        }

        $integrante->save();
        $integrante->refresh();

        //Una vez guardado el integrante, creo el evento para enviar una notificación al correo del integrante
        NuevoIntegranteCreado::dispatch($grupo, $integrante, $integrante->hash_confirmacion);

        return $integrante;
    }
}
