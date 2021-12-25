<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-120382485-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-120382485-1');
</script>


<!-- date 5 June 2021 google tag code -->
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WRTV284');</script>
<!-- End Google Tag Manager -->

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}"/>

        <link href="{{asset('/img/eye_logo1.ico')}}" rel="icon">
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

        <link rel="stylesheet" href="{{asset('css/custom_css.css')}}">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

    </head>
    <body>


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
