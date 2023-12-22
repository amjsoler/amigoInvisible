<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = ["nombre", "descripcion", "precio_minimo", "precio_maximo", "tematica_regalos", "fecha_autoasignacion"];
    protected $guarded = ["administrador", "hash", "integrantes_asignados"];



    //////////////////////
    ///// RELACIONES /////
    //////////////////////
    ///
    public function integrantesDelGrupo() : HasMany
    {
        return $this->hasMany(Integrante::class, "grupo", "id");
    }

    public function exclusionesDelGrupo() : HasMany
    {
        return $this->hasMany(Exclusion::class, "grupo", "id");
    }
}
