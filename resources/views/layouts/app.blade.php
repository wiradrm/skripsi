<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Informasi Pelayanan LPD Benana</title>
    <!-- Custom fonts for this template-->
    <link href="/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="/admin/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .bg{
            background-image: url("/bg.jpg") ;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body class="bg">
    <div class="container">
        @yield('content')
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/admin/vendor/jquery/jquery.min.js"></script>
    <script src="/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="/admin/js/sb-admin-2.min.js"></script>

    
</body>
</html>
