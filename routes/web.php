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

Route::get("/", function(){//TODO
    return "Tienes una sesión iniciada";
})->middleware("auth:sanctum")
->name("base");

Route::get("verificar-cuenta/{token}",//TODO
    [Authentication::class, "verificarCuentaConToken"]
)->name("verificarcuentacontoken");

Route::get("recuperar-cuenta/{token}",//TODO
    [Authentication::class, "recuperarCuentaGet"]
)->name("recuperarcuentaget");

Route::post("recuperar-cuenta",//TODO
    [Authentication::class, "recuperarCuentaPost"]
)->name("recuperarcuentapost");

Route::get("/login", function(){//TODO
    return view("cuentaUsuario.login");
})->middleware(["guest"])
    ->name("login");

Route::post("/login", function(Request $request){//TODO
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

Route::get("/grupos/{grupo}/apuntarse/{hash}",//TODO
    [IntegranteController::class, "getApuntarseGrupo"]
)->middleware("grupoSinAsignar");

Route::post("/grupos/{grupo}/apuntarse/{hash}",//TODO
    [IntegranteController::class, "postApuntarseGrupo"]
)->middleware("grupoSinAsignar")
    ->name("postapuntarse");

Route::get("/grupos/{grupo}/integrantes/{integrante}/aceptar-invitacion/{hash}",//TODO
    [IntegranteController::class, "aceptarInvitacion"]
)->middleware("grupoSinAsignar")
    ->name("aceptarinvitacion");



////////////////////////////
///// RUTAS DE PRUEBAS /////
////////////////////////////

Route::get("prueba-correo", function(){//TODO
    User::where("email", "amjsoler@gmail.com")->first()->notify(new PruebaBorrar());
})->middleware("auth:sanctum", "cuentaVerificada")
->can("esAdmin", User::class);

Route::get("prueba-queued-correo", function(){//TODO
    User::where("email", "amjsoler@gmail.com")->first()->notify(new PruebaQueuedBorrar());
})->middleware("auth:sanctum", "cuentaVerificada")
    ->can("esAdmin", User::class);
