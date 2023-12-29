<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/material-bootstrap-wizard.css') }}" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="{{ asset('css/demo.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body class="loanbg">
    <div id="app">

        <main class="py-4 mainpart">
            @yield('content')
        </main>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/jquery.bootstrap.js') }}" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="{{ asset('js/material-bootstrap-wizard.js') }}"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <!-- <script src="{{ asset('js/custom.js') }}"></script> -->
</body>
</html>
