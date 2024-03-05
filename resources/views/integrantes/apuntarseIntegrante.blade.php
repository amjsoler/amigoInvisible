@extends("layout")
@section("title")
    Apuntarse al grupo
@endsection
@section("content")
    <div class="flex flex-col justify-center items-center space-y-2">
        @if($response["code"] == 0)
            <h3 class="text-2xl text-white font-bold">Apuntarme al grupo {{ $grupo->nombre }}</h3>
            <form class="space-y-6 w-full" action="{{ route("postapuntarse", array("grupo" => $grupo->id, "hash" => $grupo->hash)) }}" method="POST">
                {{ csrf_field() }}
                <fieldset>
                    <label class="flex flex-col">
                        <span class="form-label dark:text-gray-200">Nombre</span>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-400
                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               value="{{old("nombre")}}"
                               name="nombre">
                        @error("nombre")
                            <span class="mt-1 text-red-500 text-xs">{{ $message }}</span>
                        @endif
                    </label>
                </fieldset>
                <fieldset>
                    <label class="flex flex-col">
                        <span class="form-label dark:text-gray-200">Correo electrónico</span>
                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-400
                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               value="{{old("correo")}}"
                               name="correo">
                        @error("correo")
                        <span class="mt-1 text-red-500 text-xs">{{ $message }}</span>
                        @endif
                    </label>
                </fieldset>
                <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                    font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600
                    dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    ¡Me apunto!
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
            <p class="text-lg font-semibold text-gray-800 dark:text-white text-center"><b>Parece que el enlace no es correcto</b></p>
            <p class="text-gray-950 dark:text-gray-200 text-center">Pide al administrador que te lo vuelva a facilitar</p>
        @endif
    </div>
@endsection
