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
        <nav-bar :user="user"></nav-bar>

        <router-view></router-view>

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
