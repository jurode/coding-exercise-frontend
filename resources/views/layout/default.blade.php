<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <meta name="csrf-token"
          content="{{ csrf_token() }}">
    <title>jobs.at coding exercise</title>

            <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
</head>
<body>
<header class="bgr-light w-100 p-3 d-flex fixed-top mb-5">
    <div class="col-2">
        <div class="rounded-circle bgr-main h-25-w-25"></div>
    </div>
    <nav class="col-10">
        <a href="/"
           class="text-dark text-decoration-none">Home</a> |
        <a href="/jobs"
           class="text-dark text-decoration-none">Add new job ad</a>
    </nav>
</header>
<div id="app" class="mt-5">
    @yield('content')
</div>

<script src="{{ mix('/js/app.js') }}"
        defer></script>
</body>
</html>
