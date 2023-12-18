<?php

use App\Http\Controllers\ApiAuthentication;
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

Route::post("/iniciar-sesion",
    [ApiAuthentication::class, "login"]
)->middleware("guest");

Route::post("/registrarse",
    [ApiAuthentication::class, "register"]
)->middleware("guest");

Route::post("/recuperar-cuenta",
    [ApiAuthentication::class, "recuperarCuenta"]
);

Route::get("/verificar-cuenta",
    [ApiAuthentication::class, "mandarCorreoVerificacionCuenta"]
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
)->middleware("auth:sanctum", "cuentaVerificada");

Route::post("/grupos",
    [GrupoController::class, "crearGrupo"]
)->middleware("auth:sanctum", "cuentaVerificada");

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



////////////////////////////////
///// RUTAS DE INTEGRANTES /////
////////////////////////////////

Route::post("/grupos/{grupo}/integrantes",
    [IntegranteController::class, "crearIntegrante"]
);

Route::delete("/grupos/{grupo}/integrantes/{integrante}",
    [IntegranteController::class, "quitarIntegrante"]
)
    ->can("administradorQuitaIntegrante", ["grupo", "integrante"])
    ->middleware("auth:sanctum", "cuentaVerificada");

Route::post("/grupos/{grupo}/integrantes/creacion-masiva",
    [IntegranteController::class, "crearIntegrantes"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada");


Route::get("/grupos/{grupo}/integrantes/celebrar-asignacion",
    [IntegranteController::class, "realizarAsignaciones"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada");

///////////////////////////////////////
/////// RUTAS DE LOG DE ERRORES ///////
///////////////////////////////////////

Route::post("/log-error", function(Request $request){
        Log::channel("front")->error($request->get("message"), $request->get("context"));
    }
);

///TODO///

/*
 * Permitir añadir excepciones a personas
 * Quitar excepciones a personas
 * Añadir fecha para reparto de premios y poder ver las asignaciones
 * Añadir fecha para autoasignación
 * Modalidades de juego
 * Autoconfirmar cuando un usuario se registra con el correo y lo verifica
 * Reenviar correo de confirmación de participación
 * Quitar a participante
 * REPASAR RUTAS Y CAPAR SEGU´N SEA ADMIN O NO
 * REPASAR RUTAS Y CAPAR CUANDO YA SE HAYA CELEBRADO EL REPARTO/ASIGNACIÓN
 */
