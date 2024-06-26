<?php
namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Helpers
{
    /**
     * @param array $integrantes
     * @return array
     *  0: OK
     * -1: Excepción
     * -2: No hay combinaciones posibles
     */
    public static function generarAsignaciones(array $integrantes, array $exclusiones = null) : array
    {
        $response["code"] = 0;
        $response["data"] = [];
        $asignacionesFinales = [];
        $matriz = [];
        $imposibleFormarAsociaciones = false;

        //Mezclamos el array
        $integrantes = Arr::flatten($integrantes);
        shuffle($integrantes);

        //1. Recorremos el array y generamos la matriz para sacar todas las combinaciones posibles
        foreach($integrantes as $integrante) {
            foreach($integrantes as $integrante2){
                if($integrante2 != $integrante){
                    $matriz[$integrante][] = $integrante2;
                }
            }
        }

        //2. Quitar las exclusiones ya creadas
        if($exclusiones){
            foreach($exclusiones as $exclusion){
                //Busco el valor a exluir en la matriz y si lo encuentro lo elimino
                $index = array_search($exclusion["usuario_excluido"], $matriz[$exclusion["usuario_que_regala"]]);
                array_splice($matriz[$exclusion["usuario_que_regala"]], $index, 1);
            }
        }

        do{
            $matriz = Helpers::ordenarMatriz($matriz);

            $elemento = $matriz[array_key_first($matriz)];

            if(count($elemento) == 0){
                $imposibleFormarAsociaciones = true;
            }else{
                $valorDeAsociacionElegido = $elemento[0];

                //Asociamos
                $asociacionesFinales[array_key_first($matriz)] = $valorDeAsociacionElegido;

                //Quitamos el array de la matriz
                unset($matriz[array_key_first($matriz)]);

                //Limpiamos el valor elegido del resto de posiciones para que no vuelva a salir
                foreach($matriz as $key=>$elemento){
                    foreach($elemento as $keyValue=>$value){
                        if($value == $valorDeAsociacionElegido){
                            array_splice($elemento, $keyValue, 1);
                            $matriz[$key] = $elemento;
                        }
                    }
                }

                $matriz = Helpers::ordenarMatriz($matriz);
            }

        }while(!$imposibleFormarAsociaciones && count($matriz) > 0);

        if($imposibleFormarAsociaciones){
            $response["code"] = -2;
        }else{
            $response["code"] = 0;
            $response["data"] = $asociacionesFinales;
        }

        return $response;
    }

    private static function ordenarMatriz($matriz)
    {
        //Ordenamos la matriz
        //Metemos un caracter a la key porque si no la función array_multisort reindexa dichas keys
        foreach($matriz as $key=>$elemento){
            $matriz['a'.$key] = $matriz[$key];
            unset($matriz[$key]);
        }

        array_multisort(array_map("count", $matriz), SORT_ASC, $matriz);

        //Volvemos a quitar el carácter
        foreach($matriz as $key=>$elemento){
            $nuevoKey = substr($key, 1);
            $matriz[$nuevoKey] = $matriz[$key];
            unset($matriz[$key]);
        }

        return $matriz;
    }
}
