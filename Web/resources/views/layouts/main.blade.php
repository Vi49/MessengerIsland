<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @vite('resources/css/app.css')

        <title>Messenger Island</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>

    <body>
        <div id="app">
            @yield('content')
        </div>


    </body>

</html>
