<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  @include('layout.app.head')
</head>
<body>
  @include('layout.app.header_second')
<main>

<div id="app">
  <app-container>
    @yield('content')
  </app-container>
</div>

</main>
</body>
</html>
