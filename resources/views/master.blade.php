<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield("title") / blog</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    
    </head>

    <body {{ Request::segment(1) ?: "home" }}>

        <header class="container">
            @include("partials.navigation")
    </header>

        <main>
            <div class="container">
                @include("partials.errors")
                @yield("content")

            </div>
        </main>


        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>

    </body>
