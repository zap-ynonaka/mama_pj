@extends('layout.app.master')

@section('content')
<h1 class="pageHeader">一時的にご利用ができません</h1>
<p>
  正常にご覧いただけるよう、解決に取り組んでおります。
  しばらく経ってもご覧いただけない場合、<a href="{{route('inquiry')}}">こちら</a>までお問い合わせ頂けますと幸いです。
  ご不便をおかけし申し訳ございません。
</p>
@endsection
