<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gamer.network</title>
        @vite('resources/css/app.css')

        <livewire:styles>
    </head>
    <body class="bg-gray-900 text-white">
        <header class="border-b border-gray-800">
            <nav class="container mx-auto flex flex-col lg:flex-row items-center justify-between px-4 py-6">
                <div class="flex flex-col lg:flex-row items-center">
                    <livewire:logo>
                    <livewire:navigation>
                </div>
                <div class="flex items-center mt-6 lg:mt-0">
                    <livewire:search>
                    <livewire:avatar>
                </div>
            </nav>
        </header>
        <main class="py-8">
            {{ $slot }}
        </main>

        <livewire:footer>
        <livewire:scripts>
    </body>
</html>