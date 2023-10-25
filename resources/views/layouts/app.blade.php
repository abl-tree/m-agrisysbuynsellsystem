<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('assets/images/logo.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Styles -->
    @if (App::isLocal())
        <!-- Bootstrap Core Css -->
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="{{ asset('assets/plugins/node-waves/waves.css') }}" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="{{ asset('assets/plugins/animate-css/animate.css') }}" rel="stylesheet" />

        <!-- Custom Css -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    @else
        @if (Request::server('HTTP_X_FORWARDED_PROTO') == 'http')
        <!-- Bootstrap Core Css -->
        <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="{{ asset('assets/plugins/node-waves/waves.css') }}" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="{{ asset('assets/plugins/animate-css/animate.css') }}" rel="stylesheet" />

        <!-- Custom Css -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        @else
        <!-- Bootstrap Core Css -->
        <link href="{{ secure_asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="{{ secure_asset('assets/plugins/node-waves/waves.css') }}" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="{{ secure_asset('assets/plugins/animate-css/animate.css') }}" rel="stylesheet" />

        <!-- Custom Css -->
        <link href="{{ secure_asset('assets/css/style.css') }}" rel="stylesheet">
        @endif
    @endif
</head>
<body class="login-page">

    @yield('content')

    <!-- Javascript -->
    @if (App::isLocal())
        <!-- Scripts -->
         <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
         
        <!-- Bootstrap Core Js -->
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.js') }}"></script>

        <!-- Waves Effect Plugin Js -->
        <script src="{{ asset('assets/plugins/node-waves/waves.js') }}"></script>

        <!-- Validation Plugin Js -->
        <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.js') }}"></script>

        <!-- Custom Js -->
        <script src="{{ asset('assets/js/admin.js') }}"></script>
        <script src="{{ asset('assets/js/pages/examples/sign-in.js') }}"></script>
    @else
        @if (Request::server('HTTP_X_FORWARDED_PROTO') == 'http')
        <!-- Scripts -->
         <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
         
        <!-- Bootstrap Core Js -->
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.js') }}"></script>

        <!-- Waves Effect Plugin Js -->
        <script src="{{ asset('assets/plugins/node-waves/waves.js') }}"></script>

        <!-- Validation Plugin Js -->
        <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.js') }}"></script>

        <!-- Custom Js -->
        <script src="{{ asset('assets/js/admin.js') }}"></script>
        <script src="{{ asset('assets/js/pages/examples/sign-in.js') }}"></script>
        @else
        <!-- Scripts -->
        <script src="{{ secure_asset('assets/plugins/jquery/jquery.min.js') }}"></script>
         
        <!-- Bootstrap Core Js -->
        <script src="{{ secure_asset('assets/plugins/bootstrap/js/bootstrap.js') }}"></script>

        <!-- Waves Effect Plugin Js -->
        <script src="{{ secure_asset('assets/plugins/node-waves/waves.js') }}"></script>

        <!-- Validation Plugin Js -->
        <script src="{{ secure_asset('assets/plugins/jquery-validation/jquery.validate.js') }}"></script>

        <!-- Custom Js -->
        <script src="{{ secure_asset('assets/js/admin.js') }}"></script>
        <script src="{{ secure_asset('assets/js/pages/examples/sign-in.js') }}"></script>
        @endif
    @endif
    
</body>
</html>
