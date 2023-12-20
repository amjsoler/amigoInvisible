@extends("layout")
@section("title")
    Grupo cerrado
@endsection
@section("content")
    <div class="d-flex flex-column justify-content-center h-100 text-center">
        <span class="material-symbols-outlined text-danger fs-1 fw-bold">close</span>
        <h3><b>Woops!</b></h3>
        <p>Parece ser que el grupo <b>{{$nombregrupo}}</b> ya se ha cerrado</p>
    </div>
@endsection
