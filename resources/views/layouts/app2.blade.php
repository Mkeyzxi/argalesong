<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Application')</title>

    <!-- Tambahkan CSS Anda di sini -->
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
</head>

<body class=" bg-gray-100 w-full h-full "> 
    {{-- flex items-center justify-center flex-wrap --}}
    <div class="flex h-screen bg-gray-200 md:bg-gray-300 lg:bg-gray-200">

        @include('partials.sidebar')

        <div class="min-w-full min-h-full flex justify-center items-center">
            @yield('content')
        </div>
    </div>
    @stack('scripts')

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

</body>



</html>
