<?php
namespace App\Helpers;

use Illuminate\Support\Collection;

class Helpers
{
    public static function generarAsignaciones(array $integrantes) : array
    {
        $asignaciones = array();

        //1. Mezclamos el array y sacamos un duplicado
        shuffle($integrantes);
        $duplicado = $integrantes;

        //2. Recorremos el array de integrantes y vamos asociando con el mismo índice+1 del de duplicados
        foreach($integrantes as $key=>$integrante) {
            $asignacion = array("integrante" => $integrante["id"]);

            if($key+1 <= count($duplicado)-1){
                $asignacion["integrante_asignado"] = $duplicado[$key+1]["id"];
                $asignacion["nombre_integrante_asignado"] = $duplicado[$key+1]["nombre"];
            }else{
                $asignacion["integrante_asignado"] = $duplicado[0]["id"];
                $asignacion["nombre_integrante_asignado"] = $duplicado[0]["nombre"];
            }

            array_push($asignaciones, $asignacion);
        }

        return $asignaciones;

    }
}
