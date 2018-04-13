@extends('layout.app.master')
@section('content')

サイトTOP<br>
<br>
<br>
今日の運勢を占う<br>
<br>
<form action="/contents/" method="post">
  {{ csrf_field() }}
  あなたの生年月日を入力<br>
  <br>
  <input type="text" name="birthday" value="{{@$birthday}}">
  <br>
  <input type="submit" name="btn_complete" value="占う" /><br>
</form>
<br>
<br>
<a href="/user/regist_input">ユーザー登録する</a><br>
<br>

@if (@$corners)
  コーナー一覧<br>
  <br>
  @foreach (@$corners as $c)
    <a href="/contents/list/{{$c->id}}">{{$c->corner_name}}</a><br>
    <br>
  @endforeach
@endif

@endsection