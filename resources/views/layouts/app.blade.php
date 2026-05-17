<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Meultech') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="antialiased bg-gray-100">
    @include('components.header')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('components.footer')

    @livewireScripts
</body>

</html>
