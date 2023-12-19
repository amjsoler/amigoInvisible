<?php

namespace App\Jobs;

use App\Http\Controllers\GrupoController;
use App\Http\Controllers\IntegranteController;
use App\Models\Grupo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ComprobarAsignacionesAutomaticas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //Leemos los grupos que no hayan sido asignados y tengan fecha de autoasignacion <= que la actual
        $grupos = Grupo::where("integrantes_asignados", false)
            ->where("fecha_autoasignacion", "<=", now())
            ->get();

        $integrantesController = new IntegranteController();

        foreach($grupos as $grupo){
            $integrantesController->realizarAsignaciones($grupo);
        }
    }
}
