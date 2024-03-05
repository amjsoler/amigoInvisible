@extends("layout")
@section("title")
    Recupera tu cuenta
@endsection
@section("content")
    <div class="flex flex-col justify-center items-center">
    @if($response["code"] == 0)
        <h3 class="text-2xl font-semibold text-gray-800 dark:text-white text-center">Cambia tu contraseña</h3>
        <form class="space-y-6 min-w-72" action="{{route("recuperarcuentapost")}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" value="{{ $response["data"]->token }}" name="token" id="token">

            <fieldset>
                <label class="flex flex-col space-y-1">
                    <span class="text-gray-800 dark:text-white">Nueva contraseña</span>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-400
                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        type="password" name="password" />
                    @error("password")
                    <p class=" text-sm text-red-400">{{ $message }}</p>
                    @endif
                </label>
            </fieldset>
            <fieldset>
                <label class="flex flex-col space-y-1">
                    <span class="text-gray-800 dark:text-white">Repite la contraseña</span>
                    <input
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-400
                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        type="password" id="password_confirmation" name="password_confirmation" />
                    @error("password_confirmation")
                    <p class=" text-sm text-red-400">{{ $message }}</p>
                    @endif
                </label>
            </fieldset>
            <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                    font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600
                    dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
                Guardar contraseña
            </button>
        </form>
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
        <p class="text-lg font-semibold text-gray-800 dark:text-white text-center"><b>Parece ser que el enlace no es válido o ha caducado</b></p>
        <p class="text-gray-950 dark:text-gray-200 text-center">Intenta solicitar un nuevo correo desde la app</p>
    @endif
    </div>
@endsection
