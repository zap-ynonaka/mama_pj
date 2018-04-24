@extends('layout.app.master')
@section('content')

<section>
  <h1 class="title-sub">{{@$menu_name}}</h1>
  <div class="second-selectList">
    <img src="http://placehold.jp/375x200.png" alt="">
    @if($affinity >= 12 && $affinity != 11)
      {{@$nickname}}x{{@$nickname2}}<br>
    <br>
    @elseif($affinity < 10 && $affinity != 1)
      {{@$nickname}}<br>
    <br>
    @endif
    <div>
    {{-- 結果が子供達など、複数回す場合があるため、かならずfor文を使用　--}}
    @foreach (@$result as $r)

      {{--　子供占いの時だけ個々に名前表示 --}}
      @if($affinity == 1 || $affinity == 11)
        名前:{{@$r['nickname']}}<br>
        <br>
      @endif

      サマリー:{{@$r['summary']}}<br>
      <br>
      結果テキスト:{{@$r['text1']}}<br>
      <br>
      <br>
    @endforeach

    @if(!@$not_favorite) {{-- 保存したお気に入りから来る時はボタン非表示--}}
    <form action="/user/favorite_regist" method="post">
      {{ csrf_field() }}
      <div class="page-back">
        <input type="submit" name="btn_input" value="結果保存する" />
      </div>
    </form>
    @endif
    </div>
  </div>

</section>





<br>
メール・LINE・ツイッター<br>
@endsection