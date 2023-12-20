@extends("layout")
@section("title")
    Recupera tu cuenta
@endsection
@section("content")
    <div class="d-flex flex-column justify-content-center h-100 text-center">
        @if($response["code"] == 0)
            <span class="material-symbols-outlined text-success fs-1 fw-bold">done</span>
            <p><b>La contraseña se ha modificado correctamente</b></p>
            <p>Ya puedes cerrar esta ventana y volver a la app</p>
        @else
            <span class="material-symbols-outlined text-danger fs-1 fw-bold">close</span>
            <p><b>Ha habido un problema al modificar la contraseña</b></p>
            <p>Prueba de nuevo y si el problema persiste, ponte en contacto con nosotros</p>
        @endif
    </div>
@endsection
