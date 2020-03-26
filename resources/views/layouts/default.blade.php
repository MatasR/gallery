<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    @include('includes.head')

  </head>
  <body>

    @include('includes.header')

    @yield('content')

    @include('includes.scripts')

  </body>
</html>
