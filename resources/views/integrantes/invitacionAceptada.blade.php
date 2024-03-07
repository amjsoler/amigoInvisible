@extends("layout")
@section("title")
    Invitación aceptada
@endsection
@section("content")
    <div class="flex flex-col justify-center items-center space-y-2">
        @if($response["code"] == 0)
            <p>
                <svg
                    class="icon icon-tabler icon-tabler-face-id-error size-16 text-green-500 dark:text-green-400"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v2" /><path d="M16 20h2a2 2 0 0 0 2 -2v-2" /><path d="M9 10l.01 0" /><path d="M15 10l.01 0" /><path d="M9.5 15a3.5 3.5 0 0 0 5 0" /></svg>
            </p>
            <p class="text-lg font-semibold text-gray-800 dark:text-white text-center"><b>Invitación aceptada correctamente</b></p>
            <p class="text-gray-950 dark:text-gray-200 text-center">Cuando el administrador genere las asignaciones, te enviaremos un email con la persona a la que regalas</p>

        <hr>
            <section class="space-y-4 mt-10">
                <p class="text-bold text-white text-center">Recuerda que desde la app puedes añadir excepciones, así, te aseguras que no te toca ese compañero pelma de la oficina...</p>
                <p class="text-semibold text-gray-200 text-center">Solo tienes que descargar la app y registrarte con el mismo correo con el que estás participando en este grupo</p>
                <!-- Enlace a la página de descarga de la app -->
            </section>
        @else
            <p class="text-gray-800 dark:text-gray-200">
                <svg
                    class="icon icon-tabler icon-tabler-face-id-error size-16 text-red-500 dark:text-red-400"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v2" /><path d="M16 20h2a2 2 0 0 0 2 -2v-2" /><path d="M9 10h.01" /><path d="M15 10h.01" /><path d="M9.5 15.05a3.5 3.5 0 0 1 5 0" /></svg>
            </p>
            <p class="text-lg font-semibold text-gray-800 dark:text-white text-center"><b>Ha habido un problema al confirmar tu participación</b></p>
            <p class="text-gray-950 dark:text-gray-200 text-center">Revisa que has copiado el enlace correctamente y si el problema persiste, ponte en contacto con el administrador. ÉL podrá apuntarte manualmente</p>
        @endif
    </div>
@endsection
