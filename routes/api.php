<?php

use App\Http\Controllers\ApiAuthentication;
use App\Http\Controllers\ExclusionController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\IntegranteController;
use App\Http\Controllers\UserController;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

//////////////////////////////////////
/////// RUTAS DE AUTENTICACIÓN ///////
//////////////////////////////////////

Route::post("/google-login",
    [ApiAuthentication::class, "googleLogin"]
)
    ->middleware("guest")
    ->name("googleLogin");

Route::post("/iniciar-sesion",
    [ApiAuthentication::class, "login"]
)
    ->middleware("guest")
    ->name("login");

Route::post("/registrarse",
    [ApiAuthentication::class, "register"]
)
    ->middleware("guest")
    ->name("register");

Route::post("/recuperar-cuenta",
    [ApiAuthentication::class, "recuperarCuenta"]
);

Route::get("/verificar-cuenta",
    [ApiAuthentication::class, "mandarCorreoVerificacionCuenta"]
)->middleware("auth:sanctum");

Route::get("/comprobar-verificacion-cuenta",
    [ApiAuthentication::class, "comprobarVerificacionCuenta"]
)->middleware("auth:sanctum");

Route::post("/cambiar-contrasena",
    [ApiAuthentication::class, "cambiarContrasena"]
)->middleware("auth:sanctum", "cuentaVerificada");

Route::post("/ajustes-cuenta",
    [UserController::class, "guardarAjustesCuentaUsuario"]
)->middleware("auth:sanctum", "cuentaVerificada");

Route::get("/ajustes-cuenta",
    [UserController::class, "leerAjustesCuentaUsuario"]
)->middleware("auth:sanctum", "cuentaVerificada");

Route::get("/eliminar-cuenta",
    [UserController::class, "eliminarCuenta"]
)->middleware("auth:sanctum", "cuentaVerificada");

Route::post("/enviar-sugerencia",
    [UserController::class, "enviarSugerencia"]
)->middleware("auth:sanctum", "cuentaVerificada");



///////////////////////////////
/////// RUTAS DE GRUPOS ///////
///////////////////////////////

Route::get("/mis-grupos",
    [GrupoController::class, "misGrupos"]
)
    ->middleware("auth:sanctum", "cuentaVerificada")
    ->name("mis-grupos");

Route::get("/grupos/{grupo}",
    [GrupoController::class, "verGrupo"]
)
    ->middleware("auth:sanctum", "cuentaVerificada")
    ->can("verGrupo", [Grupo::class, "grupo"])
    ->name("ver-grupo");

Route::post("/grupos",
    [GrupoController::class, "crearGrupo"]
)
    ->middleware("auth:sanctum", "cuentaVerificada")
    ->name("crear-grupo");

Route::post("/grupos/{grupo}",
    [GrupoController::class, "editarGrupo"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada");

Route::delete("/grupos/{grupo}",
    [GrupoController::class, "eliminarGrupo"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada");

Route::post("/grupos/{grupo}/reiniciar-grupo",
    [GrupoController::class, "reiniciarGrupo"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada");


////////////////////////////////
///// RUTAS DE INTEGRANTES /////
////////////////////////////////

Route::post("/grupos/{grupo}/integrantes",
    [IntegranteController::class, "crearIntegrante"]
)->middleware("grupoSinAsignar");

Route::delete("/grupos/{grupo}/integrantes/{integrante}",
    [IntegranteController::class, "quitarIntegrante"]
)
    ->can("administradorQuitaIntegrante", ["grupo", "integrante"])
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar");

Route::post("/grupos/{grupo}/integrantes/creacion-masiva",
    [IntegranteController::class, "crearIntegrantes"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar");

Route::get("/grupos/{grupo}/integrantes/{integrante}/reenviar-correo-confirmacion",
    [IntegranteController::class, "reenviarCorreoConfirmacion"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar");

Route::get("/grupos/{grupo}/integrantes/celebrar-asignacion",
    [IntegranteController::class, "realizarAsignaciones"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar");


Route::post("/grupos/{grupo}/integrantes/crear-exclusion",
    [ExclusionController::class, "store"]
)
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar", "usuarioApuntadoAGrupo");

Route::delete("/grupos/{grupo}/integrantes/quitar-exclusion/{exclusion}",
    [ExclusionController::class, "destroy"]
)
    ->can("usuarioQuitaExclusion", ["exclusion", "grupo"])
    ->middleware("auth:sanctum", "cuentaVerificada", "grupoSinAsignar");

///////////////////////////////////////
/////// RUTAS DE LOG DE ERRORES ///////
///////////////////////////////////////

Route::post("/log-error", function(Request $request){
        Log::channel("front")->error($request->get("message"), $request->get("context"));
    }
);
