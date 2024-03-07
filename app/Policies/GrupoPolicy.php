<?php

namespace App\Policies;

use App\Models\Grupo;
use App\Models\Integrante;
use App\Models\User;

class GrupoPolicy
{
    public function esAdministrador(User $user, Grupo $grupo) : bool
    {
        return $grupo->administrador == $user->id;
    }

    public function verGrupo(User $user, Grupo $grupo) : bool
    {
        return $grupo->integrantesDelGrupo()->where("confirmado", true)->get()->contains($user->id) ||
            $grupo->administrador == $user->id;
    }

    public function administradorQuitaIntegrante(User $user, Grupo $grupo, Integrante $integrante)
    {
        if($user->id != $grupo->administrador)
            return false;

        if($grupo->id != $integrante->grupo)
            return false;

        return true;
    }
}
