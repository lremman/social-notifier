
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@yield('title', 'SocialNotifier')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    @include('service.opengraph')
    @include('service.css')
    @include('parts.favicon')
    @include('parts.og')
    @yield('style')
  </head>
  <body>

  	@section('header')
    	@include('parts.header')
    @show

    <div class="container">

      @yield('content')

      @section('footer')
        @include('parts.footer')
      @show

    </div>

    @include('service.js')

    @section('user-js')
    @show

    </body>
</html>
