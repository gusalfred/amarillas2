<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Amarillas 365 - @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">
    <link rel='stylesheet' type='text/css' href='{{ asset('css/font-awesome.min.css') }}'>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootflat.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/rateit.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/share-button.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/amarillas365.css') }}">

    <script src="{{ asset('js/jquery-2.2.2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('js/a365.js') }}"></script>
    <script src="{{ asset('js/rateit.min.js') }}"></script>
    <script src="{{ asset('js/share-button.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
        
    <meta name="google-site-verification" content="w9NgrzouA9tEvDxcdaTXbKoaD3mhNPxwgvjmr9MrlKE" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

</head>