<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  @include('layout.app.head')
</head>
<body>
<header class="header">
  <div><a href="#"><img src="https://placehold.jp/26/3d4070/ffffff/100x100.png" alt=""></a></div>
  <div><a href="/"><h1><img src="https://placehold.jp/26/3d4070/ffffff/220x68.png" alt="３０〜５０文字前後で説明"></h1></a></div>
  <div><a href="/user/mypage"><img src="https://placehold.jp/26/3d4070/ffffff/100x100.png" alt="マイページ"></a></div>
</header>
<main>

<div id="app">
  <app-container>
    @yield('content')
  </app-container>
</div>

</main>
</body>
</html>
