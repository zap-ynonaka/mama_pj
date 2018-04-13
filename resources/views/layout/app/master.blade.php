<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  @include('layout.app.head')
</head>
<body>

　　<div id="app" v-cloak>
    <app-container
      :container="{{ $container ?? 'true' }}"
      :show-header="{{ $show_header ?? 'true' }}"
      header-layout="{{ $header_layout ?? '' }}"
      :show-footer="{{ $show_footer ?? 'false' }}"
      token-flg="{{ $token_flg ?? '' }}"
    >@yield('content')</app-container>
　　</div>

</body>
</html>
