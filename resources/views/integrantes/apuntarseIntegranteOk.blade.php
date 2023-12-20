@extends("layout")
@section("title")
    Apuntarse al grupo
@endsection
@section("content")
    <div class="d-flex flex-column justify-content-center h-100 text-center">
        @if($response["code"] == 0)
            <span class="material-symbols-outlined text-success fs-1 fw-bold">done</span>
            <p><b>Te has apuntado correctamente.</b></p>
            <p>Recuerda que tu participación no se confirmará hasta que pulses en el enlace que te hemos mandado al correo</p>
        @else
            <span class="material-symbols-outlined text-danger fs-1 fw-bold">close</span>
            <p><b>Ha habido un problema al apuntarte al grupo</b></p>
            <p>Prueba de nuevo y si el problema persiste, ponte en contacto con nosotros</p>
        @endif
    </div>
@endsection
