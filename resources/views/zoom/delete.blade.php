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
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 text-center">
            <h1 class="dark:text-white text-xl">Delete A Meeting</h1>
            @if ($errors->any())
                <div class="text-red-500 bg-red-100 border border-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="w-full mt-12" action="{{ route('zoom.destroy',1) }}" method="POST">
                @method('DELETE')
                @csrf
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="id">
                            ID
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-600"
                            id="id" name="id" type="text" placeholder="ID">
                    </div>
                </div>
                <button
                    class="shadow bg-blue-600 hover:bg-blue-500 dark:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                    type="submit">
                    Delete
                </button>
            </form>
        </div>
    </div>
</body>

</html>
