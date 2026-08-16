<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-gradient-to-br from-gray-900 via-indigo-950 to-indigo-900 flex flex-col items-center justify-center px-4 py-12 relative overflow-hidden">

            <!-- Decorative blobs -->
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-indigo-600/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -left-24 w-96 h-96 rounded-full bg-purple-600/20 blur-3xl pointer-events-none"></div>
            <div class="absolute top-1/3 left-1/4 w-64 h-64 rounded-full bg-cyan-500/10 blur-3xl pointer-events-none"></div>

            <div class="w-full max-w-md relative">
                {{ $slot }}
            </div>

            <p class="mt-8 text-xs text-indigo-200/50">
                &copy; {{ date('Y') }} {{ config('app.name', 'SMK') }}. All rights reserved.
            </p>
        </div>
    </body>
</html>