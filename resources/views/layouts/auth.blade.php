<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('/css/style.css')}}" />
    <title>Laravel</title>
</head>
<body>
<header>
    <div class="link-header">
        @guest
            @if (Route::has('login'))
                <a href="{{ route('login') }}">
                    <span>Login</span>
                </a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}">
                    <span>Register</span>
                </a>
            @endif
        @else
            <a href="#">
                <img src="{{asset('img/avatar.png')}}" alt=""/>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </a>
        @endguest
    </div>
</header>
@yield('content')
</body>
</html>

