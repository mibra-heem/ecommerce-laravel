<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Foot Wear</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

  @include('layouts.partials.header')

  @yield('content')

  @include('layouts.partials.footer')
  
  <!-- jQuery CDN (Make sure this is before any other JS files that depend on it) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Other scripts -->
  <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>

  @yield('script')
  <script src="{{ asset('assets/js/script.js') }}"></script>
  
</body>
</html>