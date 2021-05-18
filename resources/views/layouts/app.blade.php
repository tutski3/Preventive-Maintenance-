<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ICT Inventory</title>

        <link rel="icon" href="{{ asset('/img/applogo.png') }}" type="image/x-icon"/>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('fontawesome-free/css/all.css') }}" rel="stylesheet">
        
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{asset('fontawesome-free/js/all.js')}}"></script>
        
        <style>
            .rotate {
                animation:rotate-back .3s ease;
                animation-timing-function: cubic-bezier(.8,0,.5,.8);
            }

            @keyframes rotate {
                from { -webkit-transform: rotate(0deg) } 
                to { -webkit-transform: rotate(360deg) } 
            }

            .rotate-back {
                animation:rotate .3s ease;
                animation-timing-function: cubic-bezier(.8,0,.5,.8);
            }

            @keyframes rotate-back {
                from { -webkit-transform: rotate(360deg) } 
                to { -webkit-transform: rotate(0deg) } 
            }

        </style>
    </head>
    <body>
        <!-- <div id="app" class="bg-gray-100 h-full antialiased">        </div>         -->
        <div id="app">
            
        </div>
    </body>
</html>