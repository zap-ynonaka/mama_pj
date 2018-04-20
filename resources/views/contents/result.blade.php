@extends('layout.app.master')
@section('content')


<section>
  <h1 class="title-base">{{@$menu_name}}</h1>
  <div class="second-selectList">
    <img src="http://placehold.jp/375x200.png" alt="">
    <p>{{@$result['text1']}}</p>
  </div>

</section>

サマリー:{{@$result['summary']}}<br>

<br>
結果保存する<br>
<br>
メール・LINE・ツイッター<br>
@endsection