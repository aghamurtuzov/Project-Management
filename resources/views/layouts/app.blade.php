<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    <title>Admin Panel</title>
    @yield('css')
</head>
<body>
<div class="mainPage">
    <nav id="menu">
        <ul>
            <li><a href="/">Projects</a></li>
            <li><a href="https://github.com/aghamurtuzov/Project-Management.git">Documention</a></li>
        </ul>
    </nav>
    <div id="main">
        <header>
            <div class="link-header">
                <a href="">
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
                <div id="hamburger">
                    <img src="{{asset('img/hamburger.png')}}" alt=""/>
                </div>

            </div>
        </header>
        <div class="p-30">
            @yield('content')
        </div>
    </div>
</div>
<script src="{{asset('js/script.js')}}"></script>
@yield('js')
</body>
</html>
