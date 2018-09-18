<!DOCTYPE html>
<html lang="en">
  <head>
    <title>{{ config('app.site_name') . ' Page Not Found' }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('skin/css/blog-home.css') }}" rel="stylesheet">
    @yield('css')
  </head>

  <body>

    @include('frontend.templates.includes.header')
    <p style="text-align: center; margin: 100px;">Page Not Found</p>
    @include('frontend.templates.includes.footer')

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @yield('js')

  </body>

</html>