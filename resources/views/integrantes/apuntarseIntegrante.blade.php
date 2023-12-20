@extends("layout")
@section("title")
    Apuntarse al grupo
@endsection
@section("content")
    <div class="d-flex flex-column justify-content-center h-100 text-center">
        @if($response["code"] == 0)
            <h3>Apuntarme al grupo {{ $grupo->nombre }}</h3>
            @if($errors->any())
                <p class="text-danger">{{ $errors->first() }}</p>
            @endif
            <form action="{{ route("postapuntarse", array("grupo" => $grupo->id, "hash" => $grupo->hash)) }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="form-label" for="nombre">Nombre</label>
                    <input class="form-control" value="{{old("nombre")}}" type="nombre" id="nombre" name="nombre">
                </div>
                <div class="form-group">
                    <label for="correo">Correo electrónico</label>
                    <input class="form-control" value="{{old("correo")}}" type="correo" id="correo" name="correo">
                </div>
                <div class="form-group mt-4">
                    <input type="submit" class="btn btn-primary" value="¡Me apunto!">
                </div>
            </form>
        @else
            <span class="material-symbols-outlined text-danger fs-1 fw-bold">close</span>
            <p><b>Parece que el enlace no es correcto</b></p>
            <p>Pide al administrador que te lo vuelva a facilitar</p>
        @endif
    </div>
@endsection
