<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    @include('includes.head')

  </head>
  <body>
    <div class="container">

      @include('includes.header')

    </div>

    <div class="container">

      @yield('content')

    </div>

    @include('includes.scripts')

  </body>
</html>
