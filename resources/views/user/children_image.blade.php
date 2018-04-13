@extends('layout.app.master')
@section('content')

子供プロフィールアイコン編集<br>
<br>
使いたい画像を選んでください<br>
<br>

<form action="/user/children_image" method="post">
  {{ csrf_field() }}

{{-- 画像は固定っぽい、DB取得＆動的表示でなくても良さげ --}}

@for ($i = 1; $i <= 6; $i++)

{{$i}}. <img src="#">

{{-- 画像3つ毎に改行--}}
@if(($i)%3 == 0)<br>@endif

@endfor


<br>
<br>

{{-- 現在の選択画像 & タップ内容の指定画像を icon_imgfile に指定、解除なら0を指定 --}}
  <input type="hidden" name="icon_imgfile" value="{{@$icon_imgfile}}" />
  <input type="hidden" name="cid" value="{{@$cid}}" />

  <input type="submit" name="btn_choice" value="このアイコンにする" />
</form>
<form action="/user/children_profile" method="post">
  {{ csrf_field() }}
  <input type="submit" name="btn_return" value="編集ページへ戻る" />
</form>


@endsection