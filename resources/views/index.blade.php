<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HOME</title>
    </head>
    <body>
        <a href="/products">Manage products</a>

        
        @if (session('EventStatus'))
        <div class="alert-success">
            {{ session('EventStatus') }}
        </div>
        @endif

    </body>
</html>
