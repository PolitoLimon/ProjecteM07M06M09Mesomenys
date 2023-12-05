<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @env(['local','development'])
            @vite(['resources/css/app.css', 'resources/js/app.js'])  
        @endenv
        @env(['production'])
            @php
                $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
            @endphp
            <link rel="stylesheet" href="{{ asset('build/'.$manifest['resources/css/app.css']['file']) }}">
                <script type="module" src="{{ asset('build/'.$manifest['resources/js/app.js']['file']) }}"></script>
        @endenv

    </head>
    <body class="font-sans antialiased dark:bg-zinc-600">
        <div class="min-h-screen bg-black-900 dark:bg-zinc-600">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-gray dark:bg-zinc-800 m-1 p-10">
                    {{ $header }}
                </header>
            @endif
            <!-- Page Content -->
            <nav class="flex justify-between items-center ml-2 mr-2 mt-2 p-2"> 
                {{ $nav }}
            </nav>
            <main class=" bg-gray dark:bg-white text-white m-2 pt-10 pb-10">
                {{ $slot }}
            </main >

            <footer class="bg-gray dark:bg-zinc-800 text-white m-1 pl-10 pr-10 pt-5 pb-5  items-end">
                {{ $footer }}
            </footer>
        </div>
    </body>
</html>
