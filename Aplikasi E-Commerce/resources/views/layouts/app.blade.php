<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('quixlab-main') }}/theme/images/favicon.png">

    <!-- Styles -->
    <link href="{{ asset('quixlab-main') }}/theme/css/style.css" rel="stylesheet">
</head>

<body>


    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>


    @yield('script')
    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('quixlab-main') }}/theme/plugins/common/common.min.js"></script>
    <script src="{{ asset('quixlab-main') }}/theme/js/custom.min.js"></script>
    <script src="{{ asset('quixlab-main') }}/theme/js/settings.js"></script>
    <script src="{{ asset('quixlab-main') }}/theme/js/gleek.js"></script>
</body>

</html>
