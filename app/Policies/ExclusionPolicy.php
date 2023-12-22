<?php

namespace App\Policies;

use App\Models\Exclusion;
use App\Models\Grupo;
use App\Models\User;

class ExclusionPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function usuarioQuitaExclusion(User $user, Exclusion $exclusion, Grupo $grupo) : bool
    {
        $integranteIdQueRegala = $grupo->integrantesDelGrupo()->where("usuario", $user->id)->first()->id;

        if($exclusion->usuario_que_regala == $integranteIdQueRegala){
            return true;
        }
        else{
            return false;
        }
    }
}
