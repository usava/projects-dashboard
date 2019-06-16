<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-page theme-light text-default">
<div id="app">
    <nav class="bg-header section">
        <div class="container mx-auto">
            <div class="flex justify-between items-center py-2">
                <a class="navbar-brand" href="{{ url('/projects') }}">
                    {{-- LOGO --}}
                    <svg width="291" height="45" xmlns="http://www.w3.org/2000/svg" class="text-default relative">

                        <g>
                            <title>background</title>
                            <rect fill="none" id="canvas_background" height="402" width="582" y="-1" x="-1"/>
                        </g>
                        <g>
                            <title>Layer 1</title>
                            <g id="svg_1" fill-rule="evenodd" fill="none">
                                <path id="svg_4" d="m8.87192,38.194026l-3.454,2.784l6.598,0.852l-3.299,2.364l13.701,-2.364" stroke-width="0.5" stroke-opacity="0.218" class="stroke-current"/>
                                <path id="svg_5" d="m38.69092,5.194026c-14.786,0 -26.947,11.078 -28.236,25.157c2.457,-3.374 5.466,-6.621 9.223,-10.354a0.738,0.738 0 0 1 1.029,-0.01c0.286,0.273 0.29,0.722 0.01,1.001a169.806,169.806 0 0 0 -2.688,2.732l-0.175,0.184c-4.643,4.842 -7.962,9.057 -10.372,14.291a0.702,0.702 0 0 0 0.365,0.937a0.74,0.74 0 0 0 0.963,-0.356a38.585,38.585 0 0 1 2.974,-5.273c10.159,-0.253 19.406,-5.757 24.252,-14.515a0.696,0.696 0 0 0 -0.016,-0.7a0.737,0.737 0 0 0 -0.625,-0.344l-2.694,0l4.83,-2.689a0.714,0.714 0 0 0 0.328,-0.384a26.88,26.88 0 0 0 1.559,-8.969a0.718,0.718 0 0 0 -0.727,-0.708z" fill="#47D5Fa"/>
                                <text opacity="0.73" font-weight="bold" xml:space="preserve" text-anchor="start" font-family="Helvetica, Arial, sans-serif" font-size="29" id="svg_6" y="35" x="56" stroke-width="0" stroke="#000" fill="var(--text-default-color)">ProjectBoard</text>
                            </g>
                        </g>
                    </svg>
                </a>

                <div>
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <div class="flex items-center ml-auto">
                        <!-- Authentication Links -->
                        @guest

                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>

                            @if (Route::has('register'))
                                <a class="nav-link mr-4" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        @else
                            <theme-switcher></theme-switcher>

                            <dropdown align="right" width="180px">
                                <template v-slot:trigger>
                                    <button class="flex items-center text-default no-underline text-sm focus:outline-none">
                                        <img src="{{ gravatar_url(auth()->user()->email) }}" class="w-6 h-6 mr-3 rounded-full"/>
                                        {{ auth()->user()->name }}
                                    </button>
                                </template>

                                <template v-slot:default>
                                    <form method="POST" action="/logout">
                                        @csrf
                                        <button type="submit" class="dropdown-menu-link w-full text-left">Logout</button>
                                    </form>
                                </template>

                            </dropdown>

                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="w-4/5 mx-auto p-6">
        @yield('content')
    </main>
</div>

<!-- Optional JavaScript -->

</body>
</html>
