<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

 
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" >

    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" >
 
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}" >

    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" >
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" >

    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" >


    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

<style>
    a{
        text-decoration: none;
    }
    
</style>
</head>

<body >
    <!-- Header Section -->
    @include('web.partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')

    </main>

    <!-- Footer Section -->
    @include('web.partials.footer')

    
    <!-- JS Files -->
     <!-- Js Plugins -->
     {{-- <script src="js/jquery-3.3.1.min.js"></script> --}}
     {{-- <script src="js/bootstrap.min.js"></script> --}}
     <script src="{{ asset('js/bootstrap.min.js') }}"></script>
     <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
     <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
     <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
     <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
     <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
     <script src="{{ asset('js/main.js') }}"></script>

 </body>
 
 </html>
</body>
</html>