@extends("layout")
@section("title")
    Iniciar sesión
@endsection
@section("content")
    <div class="d-flex flex-column justify-content-center h-100 text-center">
        <h3>Inicia sesión</h3>
        <form action="{{route("login")}}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input class="form-control" type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input class="form-control" type="password" id="password" name="password">
            </div>
            <div class="form-group mt-4">
                <input type="submit" class="btn btn-primary" value="Iniciar sesión">
            </div>
        </form>
    </div>
@endsection
