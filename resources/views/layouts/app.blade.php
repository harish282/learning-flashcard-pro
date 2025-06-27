<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Flashcard Pro') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('css')
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen max-w-7xl mx-auto">
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            {{ $header }}
        </header>
        @endif

        <!-- Page Content -->
        <main>
            <x-messages />
            {{ $slot }}
        </main>
        <section class="footer py-12">
            <div class="max-w-7xl w-full mx-auto sm:px-6">
                @if (isset($footer))
                    {{ $footer }}
                @else
                    <livewire:layout.footer />
                @endif
            </div>
        </section>
    </div>
    @stack('js')
</body>

</html>