@extends("layout")
@section("title")
    Recupera tu cuenta
@endsection
@section("content")
    <div class="flex flex-col justify-center items-center space-y-2">
        @if($response["code"] === 0)
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
            <p class="text-lg font-semibold text-gray-800 dark:text-white text-center"><b>La contraseña se ha modificado correctamente</b></p>
            <p class="text-gray-950 dark:text-gray-200 text-center">Ya puedes cerrar esta ventana y volver a la app</p>
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
            <p class="text-lg font-semibold text-gray-800 dark:text-white text-center"><b>Ha habido un problema al modificar la contraseña</b></p>
            <p class="text-gray-950 dark:text-gray-200 text-center">Prueba de nuevo y si el problema persiste, ponte en contacto con nosotros</p>
        @endif
    </div>
@endsection
