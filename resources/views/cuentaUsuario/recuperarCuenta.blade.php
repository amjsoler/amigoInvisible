@extends("layout")
@section("title")
    Recupera tu cuenta
@endsection
@section("content")
    <div class="d-flex flex-column justify-content-center h-100 text-center">
        @if($response["code"] == 0)
            <h3>Cambia tu contraseña</h3>
            @if($errors->any())
                <p class="text-danger">{{ $errors->first() }}</p>
            @endif
            <form action="{{route("recuperarcuentapost")}}" method="post">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $response["data"]->token }}" name="token" id="token">
                <div class="form-group">
                    <label for="password">Nueva contraseña</label>
                    <input class="form-control" type="password" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Repite la nueva contraseña</label>
                    <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
                </div>
                <div class="form-group mt-4">
                    <input type="submit" class="btn btn-primary" value="Cambiar Contraseña">
                </div>
            </form>
        @else
            <span class="material-symbols-outlined text-danger fs-1 fw-bold">close</span>
            <p><b>Parece ser que el enlace no es válido o ha caducado.</b></p>
            <p>Intenta solicitar un nuevo correo desde la app</p>
        @endif
    </div>
@endsection
