<!DOCTYPE html>
<html lang="es" class="h-100">
<meta charset="UTF-8">
<title>Woops!</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}">
<script src="{{asset("js/bootstrap.bundle.min.js")}}"></script>
<body class="h-100">
    <div class="container h-100 d-block">
        @yield("content")
    </div>
</body>
</html>
