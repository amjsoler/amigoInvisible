apuntarse al grupo

<form action="{{ route("postapuntarse", array("grupo" => $grupo->id, "hash" => $grupo->hash)) }}" method="POST">
    {{ csrf_field() }}
    <input type="text" name="nombre">
    <input type="email" name="correo">
    <input type="submit" value="Apuntarme">
</form>
