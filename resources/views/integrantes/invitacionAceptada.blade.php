@extends("layout")
@section("title")
    Invitación aceptada
@endsection
@section("content")
    <div class="d-flex flex-column justify-content-center h-100 text-center">
        @if($response["code"] == 0)
            <span class="material-symbols-outlined text-success fs-1 fw-bold">done</span>
            <p><b>Invitación aceptada correctamente</b></p>
            <p>Cuando el administrador genere las asignaciones, te enviaremos un email con la persona a la que regalas</p>
        @else
            <span class="material-symbols-outlined text-danger fs-1 fw-bold">close</span>
            <p><b>Ha habido un problema al confirmar tu participación</b></p>
            <p>Revisa que has copiado el enlace correctamente y si el problema persiste, ponte en contacto con el administrador. ÉL podrá apuntarte manualmente</p>
        @endif
    </div>
@endsection
