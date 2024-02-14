<?php

use App\Http\Controllers\ApiAuthentication;
use App\Http\Controllers\ExclusionController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\IntegranteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

//////////////////////////////////////
/////// RUTAS DE AUTENTICACIÓN ///////
//////////////////////////////////////

Route::post("/iniciar-sesion", //TODO
    [ApiAuthentication::class, "login"]
)
    ->middleware("guest")
    ->name("login");

Route::post("/registrarse",//TODO
    [ApiAuthentication::class, "register"]
)
    ->middleware("guest")
    ->name("register");

Route::post("/recuperar-cuenta",//TODO
    [ApiAuthentication::class, "recuperarCuenta"]
);

Route::get("/verificar-cuenta",//TODO
    [ApiAuthentication::class, "mandarCorreoVerificacionCuenta"]
)->middleware("auth:sanctum");

Route::post("/cambiar-contrasena",//TODO
    [ApiAuthentication::class, "cambiarContrasena"]
)->middleware("auth:sanctum", "cuentaVerificada");

Route::post("/ajustes-cuenta",//TODO
    [UserController::class, "guardarAjustesCuentaUsuario"]
)->middleware("auth:sanctum", "cuentaVerificada");

Route::get("/ajustes-cuenta",//TODO
    [UserController::class, "leerAjustesCuentaUsuario"]
)->middleware("auth:sanctum", "cuentaVerificada");

Route::get("/eliminar-cuenta",//TODO
    [UserController::class, "eliminarCuenta"]
)->middleware("auth:sanctum", "cuentaVerificada");

Route::post("/enviar-sugerencia",//TODO
    [UserController::class, "enviarSugerencia"]
)->middleware("auth:sanctum", "cuentaVerificada");



///////////////////////////////
/////// RUTAS DE GRUPOS ///////
///////////////////////////////

Route::get("/mis-grupos",//TODO
[GrupoController::class, "misGrupos"]
)
    ->middleware("auth:sanctum", "cuentaVerificada")
    ->name("mis-grupos");

Route::post("/grupos",//TODO
    [GrupoController::class, "crearGrupo"]
)
    ->middleware("auth:sanctum", "cuentaVerificada")
    ->name("crear-grupo");

Route::post("/grupos/{grupo}",//TODO
    [GrupoController::class, "editarGrupo"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada");

Route::delete("/grupos/{grupo}",//TODO
    [GrupoController::class, "eliminarGrupo"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada");

Route::post("/grupos/{grupo}/reiniciar-grupo",//TODO
    [GrupoController::class, "reiniciarGrupo"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada");


////////////////////////////////
///// RUTAS DE INTEGRANTES /////
////////////////////////////////

Route::post("/grupos/{grupo}/integrantes",//TODO
    [IntegranteController::class, "crearIntegrante"]
)->middleware("grupoSinAsignar");

Route::delete("/grupos/{grupo}/integrantes/{integrante}",//TODO
    [IntegranteController::class, "quitarIntegrante"]
)
    ->can("administradorQuitaIntegrante", ["grupo", "integrante"])
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar");

Route::post("/grupos/{grupo}/integrantes/creacion-masiva",//TODO
    [IntegranteController::class, "crearIntegrantes"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar");

Route::get("/grupos/{grupo}/integrantes/{integrante}/reenviar-correo-confirmacion",//TODO
    [IntegranteController::class, "reenviarCorreoConfirmacion"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar");

Route::get("/grupos/{grupo}/integrantes/celebrar-asignacion",//TODO
    [IntegranteController::class, "realizarAsignaciones"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar");


Route::post("/grupos/{grupo}/integrantes/crear-exclusion",//TODO
    [ExclusionController::class, "store"]
)
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar", "usuarioApuntadoAGrupo");

Route::delete("/grupos/{grupo}/integrantes/quitar-exclusion/{exclusion}",//TODO
    [ExclusionController::class, "destroy"]
)
    ->can("usuarioQuitaExclusion", ["exclusion", "grupo"])
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar");

///////////////////////////////////////
/////// RUTAS DE LOG DE ERRORES ///////
///////////////////////////////////////

Route::post("/log-error", function(Request $request){//TODO
        Log::channel("front")->error($request->get("message"), $request->get("context"));
    }
);

///TODO///

/*
 * Permitir añadir excepciones a personas
 * Quitar excepciones a personas
 * Modalidades de juego (Normal, ruleta de regalos, deseos del amigo invisible)
 * LLamada a la acción para registrarse alegando que podrá excluir gente ahí
 */
