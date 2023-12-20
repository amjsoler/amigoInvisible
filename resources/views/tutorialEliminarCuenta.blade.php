@extends("layout")
@section("title")
    ¿Cómo eliminar mi cuenta?
@endsection
@section("content")
    <h2>¿Cómo eliminar tu cuenta y todos tus datos?</h2>

    <p>El proceso es simple:</p>
    <ol>
        <li>Iniciar sesión como usuario</li>
        <li>Ir a la sección del perfil</li>
        <li>Descender hasta abajo hasta encontrar el botón de <b>"Eliminar cuenta"</b></li>
        <li>Aparecerá otro botón que dice <b>"Eliminar esta cuenta"</b>. Pulsando en él, tu cuenta y tus datos habrán quedado totalmente eliminados</li>
    </ol>

    <p>
        <b>Si no consiguieses completar el proceso, puedes escribirnos a <b>{{env("CORREO_CONTACTO")}}</b> y solicitar la eliminación de tus datos. <b>Deberás escribirnos desde la dirección de correo registrada en el usuario a eliminar</b></b>
    </p>
@endsection
