<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HikeGuide') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    @include('layouts.navigation')

    <main class="flex flex-col items-center justify-center min-h-[calc(100vh-4rem)] px-4 py-12">
        <a href="/" class="text-2xl font-bold text-orange-600 mb-6 tracking-tight">HikeGuide</a>
        <div class="w-full max-w-md bg-white rounded-xl shadow-sm border border-gray-200 px-8 py-8">
            {{ $slot }}
        </div>
    </main>

</body>
</html>
