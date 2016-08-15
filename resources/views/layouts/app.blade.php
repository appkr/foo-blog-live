<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Laravel</title>

  <!-- Styles -->
  <link href="/css/app.css" rel="stylesheet">
</head>
<body>
  @include('layouts.navigation')

  <div class="container">
    @include('flash::message')
    @include('layouts.js-flash')

    @yield('content')
  </div>

  <!-- Scripts -->
  <script src="/js/app.js"></script>

  @stack('script')
</body>
</html>
