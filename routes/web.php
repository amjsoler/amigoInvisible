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

Route::get("/", function(){
    return "Tienes una sesión iniciada";
})->middleware("auth:sanctum")
->name("base");

Route::get("verificar-cuenta/{token}",
    [Authentication::class, "verificarCuentaConToken"]
)
    ->name("verificarcuentacontoken");

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
        return redirect()->route("base");
    }else{
        return redirect()->back();
    }
})->middleware(["guest"]);



///////////////////////////
///// RUTAS GENERALES /////
///////////////////////////

Route::get("politica-de-privacidad", function(){//TODO
    return view("politicaDePrivacidad");
});

Route::get("tutorial-eliminar-cuenta", function() {//TODO
    return view("tutorialEliminarCuenta");
});



/////////////////////////////
///// RUTAS INTEGRANTES /////
/////////////////////////////

Route::get("/grupos/{grupo}/apuntarse/{hash}",
    [IntegranteController::class, "getApuntarseGrupo"]
)->middleware("grupoSinAsignar");

Route::post("/grupos/{grupo}/apuntarse/{hash}",
    [IntegranteController::class, "postApuntarseGrupo"]
)->middleware("grupoSinAsignar")
    ->name("postapuntarse");

Route::get("/grupos/{grupo}/integrantes/{integrante}/aceptar-invitacion/{hash}",
    [IntegranteController::class, "aceptarInvitacion"]
)->middleware("grupoSinAsignar")
    ->name("aceptarinvitacion");



////////////////////////////
///// RUTAS DE PRUEBAS /////
////////////////////////////

Route::get("prueba-correo", function(){
    User::where("email", env("ADMIN_AUTORIZADO"))->first()->notify(new PruebaBorrar());
    return "Email enviado";
})
    ->middleware("auth:sanctum", "cuentaVerificada")
    ->can("esAdmin", [User::class]);

Route::get("prueba-queued-correo", function(){
    User::where("email", env('ADMIN_AUTORIZADO'))->first()->notify(new PruebaQueuedBorrar());
    return "Email enviado";
})
    ->middleware("auth:sanctum", "cuentaVerificada")
    ->can("esAdmin", [User::class, "prueba-queued-correo"]);
