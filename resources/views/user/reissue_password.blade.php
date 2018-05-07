@extends('layout.app.master')

@section('content')

@include('layout.error_message')

@if(@$btn_send)   {{-- 2. メール送信 --}}

<h1 class="pageTitle">パスワードの再発行</h1>

パスワード再発行メールを送信しました。<br>

@elseif(@$btn_chenge)  {{-- 4. パスワード変更完了 --}}

<h1 class="pageTitle">パスワード再設定完了</h1>

パスワードの再設定が完了しました。<br>


@elseif(@$reissue_key)  {{-- 3. 送信メールからのパスワード入力 --}}

<h1 class="pageTitle">パスワードの再設定</h1>

<form method="post" action="/user/reissue_password">
  {{ csrf_field() }}
  パスワード<br>
  <input type="text" name="new_password" value="" /><br>
  パスワード確認用<br>
  <input type="text" name="re_new_password" value="" /><br>
  <input type="hidden" name="reissue_key" value="{{$reissue_key}}" /><br>
  <input type="submit" name="btn_chenge" value="登録する">
</form>

@else   {{-- 1. 初回 --}}

<h1 class="pageTitle">パスワードの再発行</h1>

<form method="post" action="/user/reissue_password">
  {{ csrf_field() }}
  <input type="text" name="email" value="" /><br>
  <input type="submit" name="btn_send" value="送信する">
</form>

@endif
@endsection


