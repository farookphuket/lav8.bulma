<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}"/>
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{asset('css/app.css')}}">

    </head>
    <body class="antialiased">
        @if (Auth::check())
            @php
            $user_auth_data = [
                'isLoggedin' => true,
                'user' =>  Auth::user()
            ];
            @endphp
        @else
            @php
            $user_auth_data = [
                'isLoggedin' => false
            ];
            @endphp
        @endif
        <script>
            window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
        </script>
        <div id="app">
            
        </div>
        @yield('content')

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
