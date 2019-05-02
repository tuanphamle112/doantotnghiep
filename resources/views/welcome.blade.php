<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>

<body>
    <h3>{{ __('Test') }}</h3>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/') }}">{{ __('Home') }}</a>
            @else
            <a href="{{ route('login') }}">{{ __('Login') }}</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif
            @endauth
        </div>
        @endif
    </div>
</body>

</html>
