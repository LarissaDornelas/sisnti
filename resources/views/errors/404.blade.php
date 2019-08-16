@auth
@section('title')
Página não encontrada
@stop
@extends('base')
@section('content')
@endauth
@guest
<html>
    <title>Página não encontrada</title>
    <head>
@endguest        
       
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .code {
                border-right: 2px solid;
                font-size: 26px;
                padding: 0 15px 0 15px;
                text-align: center;
            }

            .message {
                font-size: 18px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="text-muted flex-center position-ref full-height">
            <div class="code">
                404            </div>

            <div class="message" style="padding: 10px;">
                Not Found            </div>
        </div>
    </body>
</html>
@auth
@stop    
@endauth