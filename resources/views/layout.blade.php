<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8">
    <title>
        @hasSection ('title')
            @yield('title') - {{ env("APP_NAME") }}
        @else
            {{ env("APP_NAME") }}
        @endif
    </title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @vite('resources/css/app.css')
</head>
<body class="h-dvh flex flex-col justify-center items-center bg-white dark:bg-gray-900">
    <div class="bg-gray-300 dark:bg-gray-700 mx-4 px-8 py-4 rounded-lg">
        @yield("content")
    </div>
</body>
</html>
