<meta charset="utf-8">
<meta name="author" content="ZAPPALLAS, Inc.">
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- 会員登録用 css & js --}}
<link rel="stylesheet" type="text/css" href="/css/plus-custom.css">
<link rel="stylesheet" type="text/css" href="/css/plus-style.css">
<link rel="stylesheet" type="text/css" href="/css/app.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<script src="/js/fingerprint.js"></script>  {{-- ゲスト集計用 ユニークID取得機能 --}}


<title>@if (isset($title) && $title != ''){{ $title }}@else コンテンツタイトル @endif</title>

<script>
window.Laravel = {};
Laravel.csrfToken = '{{ csrf_token() }}';
Laravel.cpno = '{{ $cpno ?? '' }}';
</script>

{{-- google analytics --}}
@include('layout.ga')
