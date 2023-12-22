<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Exclusion extends Model
{
    use HasFactory;

    protected $table = "exclusiones";
    protected $guarded = ["usuario_que_regala", "usuario_excluido"];

    //////////////////////
    ///// RELACIONES /////
    //////////////////////

    public function dameUsuarioQueRegala() : HasOne
    {
        return $this->hasOne(Integrante::class, "usuario_que_regala", "id");
    }

    public function dameUsuarioExcluido() : HasMany
    {
        return $this->hasMany(Integrante::class, "usuario_excluido", "id");
    }
}
