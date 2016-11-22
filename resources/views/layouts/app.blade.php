<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ (Auth::user()) ? Auth::user()->api_token : "" }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'apiToken' => (Auth::user()) ? Auth::user()->api_token : false
        ]); ?>
    </script>
</head>
<body>
    <div id="app">

        <nav class="navbar navbar-light navbar-full ">
            <div class="container">
                <a class="navbar-brand" href="/">MagicMirror<span>²</span></a>
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a href="{{ url('/modules') }}" class="nav-link"><i class="fa fa-fw fa-cubes" aria-hidden="true"></i> Modules</a></li>
                </ul>
                <ul class="nav navbar-nav float-lg-right">
                    @if (Auth::guest())
                        <li class="nav-item"><a href="{{ url('/auth/github') }}" class="btn btn-outline-primary"><i class="fa fa-github" aria-hidden="true"></i> Login with GitHub</a></li>
                    @else
                        <img src="{{ Auth::user()->avatar }} " alt="Avatar" class="rounded-circle avatar">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="responsiveNavbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="responsiveNavbarDropdown">
                                <a class="dropdown-item" href="{{ action('ModuleController@create') }}">
                                    <i class="fa fa-fw fa-plus-circle" aria-hidden="true"></i> Add Module
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        @yield('content')

        <footer class="footer">
            <div class="container text-xs-center">
                <span class="text-muted">MagicMirror² - ©2016 <a href="http://michaelteeuw.nl" target="_blank">Michael Teeuw</a>, Xonay Media.</span>
            </div>
        </footer>
        
    </div>

    
    <!-- Scripts -->
    <script src="{{ elixir('js/app.js') }}"></script>
</body>
</html>
