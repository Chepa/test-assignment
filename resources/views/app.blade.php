<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @vite('resources/css/app.scss')
    </head>
    <body>
    <div class="container py-4">
        <div id="app"></div>
    </div>
    @vite('resources/js/app.js')
    <script type="text/javascript">window.languages = @json($languages)</script>
    </body>
</html>
