<?php
namespace App\Helpers;

use Illuminate\Support\Collection;

class Helpers
{
    public static function generarAsignaciones(array $integrantes) : array
    {
        $asignaciones = $integrantes;

        foreach($asignaciones as $key=>$asignacion){
            $indexRand = rand(0, count($integrantes)-1);
if($key==2 && $integrantes[$indexRand]["id"] == $asignacion["id"])dd($asignaciones, $asignacion, $integrantes, $indexRand);

            while($integrantes[$indexRand]["id"] == $asignacion["id"]){
                $indexRand = rand(0, count($integrantes)-1);
            }
            $asignaciones[$key]["integrante_asignado"] = $integrantes[$indexRand]["id"];
            $asignaciones[$key]["nombre_integrante_asignado"] = $integrantes[$indexRand]["nombre"];
            array_splice($integrantes, $indexRand, 1);
        }

        return $asignaciones;

    }
}
