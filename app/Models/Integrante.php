<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Integrante extends Model
{
    use HasFactory;

    protected $fillable = ["nombre", "correo"];
    protected $guarded = ["grupo", "usuario", "confirmado", "hash_confirmacion", "integrante_asignado"];
    protected $hidden = ["integrante_asignado"];

    public function grupoPerteneciente() : BelongsTo
    {
        return $this->belongsTo(Grupo::class, "grupo", "id");
    }

    public function exclusionesDelIntegrante() : HasMany
    {
        return $this->hasMany(Exclusion::class, "usuario_que_regala", "id");
    }
}

