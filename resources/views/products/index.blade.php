<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Products</title>

</head>

<body>


    @if (session('EventStatus'))
    <h2>
        {{ session('EventStatus') }}
    </h2>
    @endif

    <h1>Current Products</h1>

    @if (\App\Product::all()->count())
    <ul>
        @foreach (\App\Product::all() as $product)
        <li>
            {!! $product->name !!}
            {!! $product->Description !!}
            <form action="/products/delete" method="POST">
                @csrf
                <input type="hidden" name="id" value="@php(print $product->id)" />
                <button type="submit">delete</button>
            </form>
        </li>
        @endforeach
    </ul>
    @else
    <p><em>No products have been created yet.</em></p>
    @endif



    @if (session('status'))
    <div class="alert-success">
        {{ session('status') }}
    </div>
    @endif

    @if (session('statusBad'))
    <div class="alert-danger">
        {{ session('statusBad') }}
    </div>
    @endif


    <h2>New product</h2>
    <form action="/products/new" method="POST">
        @csrf
        <input type="text" name="name" placeholder="name" /><br />
        <textarea name="description" placeholder="description"></textarea><br />
        <input type="text" name="tags" placeholder="tags" /><br />
        <button type="submit">Submit</button>
    </form>

</body>

</html>