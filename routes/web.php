<?php

use App\Http\Controllers\IntegranteController;
use App\Http\Controllers\web\Authentication;
use App\Models\User;
use App\Notifications\PruebaBorrar;
use App\Notifications\PruebaQueuedBorrar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

///////////////////////////////
/////// RUTAS DE CUENTA ///////
///////////////////////////////

Route::get("/con-sesion", function(){
    return "Tienes una sesión iniciada";
})->middleware("auth:sanctum")->name("consesion");

Route::get("verificar-cuenta/{token}",
    [Authentication::class, "verificarCuentaConToken"]
)->name("verificarcuentacontoken");

Route::get("recuperar-cuenta/{token}",
    [Authentication::class, "recuperarCuentaGet"]
)->name("recuperarcuentaget");

Route::post("recuperar-cuenta",
    [Authentication::class, "recuperarCuentaPost"]
)->name("recuperarcuentapost");

Route::get("/login", function(){
    return view("cuentaUsuario.login");
})->middleware(["guest"])
    ->name("login");

Route::post("/login", function(Request $request){
    if(Auth::attempt(array("email" => $request->get("email"), "password" => $request->get("password")))){
    }else{
        return redirect()->back();
    }
})->middleware(["guest"]);



///////////////////////////
///// RUTAS GENERALES /////
///////////////////////////

Route::get("politica-de-privacidad", function(){
    return view("politicaDePrivacidad");
});

Route::get("tutorial-eliminar-cuenta", function() {
    return view("tutorialEliminarCuenta");
});



/////////////////////////////
///// RUTAS INTEGRANTES /////
/////////////////////////////

Route::get("/grupos/{grupo}/apuntarse/{hash}",
    [IntegranteController::class, "getApuntarseGrupo"]
);

Route::post("/grupos/{grupo}/apuntarse/{hash}",
    [IntegranteController::class, "postApuntarseGrupo"]
)->name("postapuntarse");

Route::get("/grupos/{grupo}/integrantes/{integrante}/aceptar-invitacion/{hash}",
    [IntegranteController::class, "aceptarInvitacion"]
)->name("aceptarinvitacion");



////////////////////////////
///// RUTAS DE PRUEBAS /////
////////////////////////////

Route::get("prueba-correo", function(){
    User::where("email", "amjsoler@gmail.com")->first()->notify(new PruebaBorrar());
})->middleware("auth:sanctum", "cuentaVerificada")
->can("esAdmin", User::class);

Route::get("prueba-queued-correo", function(){
    User::where("email", "amjsoler@gmail.com")->first()->notify(new PruebaQueuedBorrar());
})->middleware("auth:sanctum", "cuentaVerificada")
    ->can("esAdmin", User::class);

Route::get("/grupos/{grupo}/integrantes/celebrar-asignacion",
    [IntegranteController::class, "realizarAsignaciones"]
)
    ->can("esAdministrador", "grupo")
    ->middleware("auth:sanctum", "cuentaVerificada");
