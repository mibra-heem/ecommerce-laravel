<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <title>@yield('title')</title>
</head>
<body>

  @yield('content')

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>