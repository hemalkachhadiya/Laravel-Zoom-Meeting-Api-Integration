<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased bg-white dark:bg-gray-900">
        <h1 class="text-4xl text-blue-600 dark:text-blue-300 text-center mt-12 font-bold">Zoom Integration With Laravel</h1>
        <div class="relative flex items-top justify-center min-h-screen py-4 sm:pt-0 mt-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-center">
                    <div class="col-span-1 w-96 bg-gray-400 bg-opacity-50 h-48 rounded-lg flex items-center justify-center">
                        <a href="{{ route('zoom.create') }}" class="text-xl dark:text-white">Create a Meeting</a>
                    </div>
                    <div class="col-span-1 w-96 bg-gray-400 bg-opacity-50 h-48 rounded-lg flex items-center justify-center">
                        <a href="{{ route('zoom.edit',1) }}" class="text-xl dark:text-white">Update a Meeting</a>
                    </div>
                    <div class="col-span-1 w-96 bg-gray-400 bg-opacity-50 to-blue-400 h-48 rounded-lg flex items-center justify-center">
                        <a href="{{ route('zoom.delete') }}" class="text-xl dark:text-white">Delete a Meeting</a>
                    </div>
                    <div class="col-span-1 w-96 bg-gray-400 bg-opacity-50 to-blue-400 h-48 rounded-lg flex items-center justify-center">
                        <a href="{{ url('/zoom') }}" class="text-xl dark:text-white">Check a Meeting</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
