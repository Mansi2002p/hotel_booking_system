<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="description" content="POS - Bootstrap Admin Template">
<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
<meta name="author" content="Dreamguys - Bootstrap Admin Template">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="noindex, nofollow">
<title>Hotel  Pannel</title>

<link rel="shortcut icon" type="image/x-icon" href="admin/img/favicon.jpg">

{{-- <link rel="stylesheet" href="admin/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}">
{{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}

<link rel="stylesheet" href="{{asset('admin/css/animate.css')}}">

<link rel="stylesheet" href="{{asset('admin/css/dataTables.bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('admin/plugins/fontawesome/css/fontawesome.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/plugins/fontawesome/css/all.min.css')}}">

<link rel="stylesheet" href="{{asset('admin/css/style.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> --}}
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>


    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" />


</head>
<body>
<div id="global-loader">
<div class="whirly-loader"> </div>
</div>

<div class="main-wrapper ">
      <!-- Header Section -->
      @include('backend.hotel-owner-partials.header')

      <!-- Main Content -->
      <main  style="margin-top: 100px">
          @yield('content')
      </main>
  
      <!-- Footer Section -->
      @include('backend.hotel-owner-partials.sidebar')
</div>


<script src="{{asset('admin/js/jquery-3.6.0.min.js')}}"></script>

<script src="{{asset('admin/js/feather.min.js')}}"></script>

<script src="{{asset('admin/js/jquery.slimscroll.min.js')}}"></script>

<script src="{{asset('admin/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/js/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('admin/plugins/apexchart/apexcharts.min.js')}}"></script>
<script src="{{asset('admin/plugins/apexchart/chart-data.js')}}"></script>

<script src="{{asset('admin/js/script.js')}}"></script>
</body>
</html>
