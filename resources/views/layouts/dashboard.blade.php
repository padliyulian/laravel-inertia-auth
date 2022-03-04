<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/favicon.ico" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback"
    >
    <link
        rel="stylesheet"
        href="{{asset('/assets/vendor/fontawesome/css/all.css')}}"
    >
    <link
        rel="stylesheet"
        href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
    >
    <link
        rel="stylesheet"
        href="{{asset('/assets/vendor/adminlte/icheck-bootstrap.min.css')}}"
    >
    <link
        rel="stylesheet"
        href="{{asset('/assets/vendor/adminlte/adminlte.min.css')}}"
    >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>

    @inertiaHead
</head>
<body class="hold-transition sidebar-mini layout-fixed">

    @inertia

    <script src="{{asset('/assets/vendor/adminlte/jquery.min.js')}}"></script>
    <script src="{{asset('/assets/vendor/adminlte/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('/assets/vendor/adminlte/adminlte.min.js')}}"></script>
    <script src="{{asset('/assets/vendor/sweetalert/sweetalert2@10.js')}}"></script>
</body>
</html>
