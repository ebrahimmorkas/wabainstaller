<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SimpleWaba') }}</title>

    {{-- If you’re using Vite (Breeze/Jetstream): --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900">
    <div class="min-h-screen">
        <nav class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="font-semibold">{{ config('app.name', 'SimpleWaba') }}</a>
                <div class="flex items-center gap-4">
                    @auth
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm text-gray-700 hover:underline">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
