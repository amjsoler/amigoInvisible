@extends("layout")
@section("title")
    Verificación de cuenta
@endsection
@section("content")
    <div class="d-flex flex-column justify-content-center h-100 text-center">
        @if($response["code"] == 0)
            <span class="material-symbols-outlined text-success fs-1 fw-bold">done</span>
            <p><b>La cuenta se ha verificado correctamente</b></p>
            <p>Ya puedes cerrar esta ventana y volver a la app</p>
        @else
            <span class="material-symbols-outlined text-danger fs-1 fw-bold">close</span>
            <p><b>Al parecer el link ya no era válido</b></p>
            <p>Prueba a volver a solicitar el correo de verificación desde la app</p>
        @endif
    </div>
@endsection
