<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}"/>

        @hasSection('meta_title')
            <title>@yield('meta_title')</title>
        @else 

            @auth

            <title>{{Request::segment(2)}}</title>
            @else

            <title>{{Request::segment(1)}}</title>
            @endauth
        @endif

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{asset('css/app.css')}}">

    </head>
    <body class="antialiased">


        @auth 
            
        <script>
            var user_id = '{!!Auth::user()->id!!}'
        </script>
        @endif
        <div id="app">
            
        </div>
        @yield('content')

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
