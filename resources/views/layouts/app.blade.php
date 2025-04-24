<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- icono de la web en svg -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2250%22 height=%2250%22 viewBox=%220 0 100 100%22 fill=%22none%22><rect width=%22100%22 height=%22100%22 rx=%2215%22 fill=%22%23eafaf1%22/><rect x=%2210%22 y=%2270%22 width=%2280%22 height=%2220%22 rx=%225%22 fill=%22%23a1887f%22/><path d=%22M50 60 C45 55, 40 50, 50 50 C60 50, 55 55, 50 60%22 fill=%22%2381c784%22/><path d=%22M50 60 C47 55, 43 52, 50 51 C57 52, 53 55, 50 60%22 fill=%22%2366bb6a%22/><rect x=%2248.5%22 y=%2260%22 width=%223%22 height=%2210%22 fill=%22%234caf50%22/><circle cx=%2280%22 cy=%2220%22 r=%2210%22 fill=%22%23fff176%22/></svg>" type="image/svg+xml">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    </body>
</html>
