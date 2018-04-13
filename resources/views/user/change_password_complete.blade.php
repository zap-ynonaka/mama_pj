@extends('layout.app.master')

@section('content')
<div class="contentBody">
  <div class="contentBody__section">
    <h1>パスワードの変更</h1>
    <p>新しいパスワードを設定しました。</p>
  </div>
</div>
<div class="contentFooter">
  <a href="/user/login" class="btn"
    data-color="primary"
    data-block="true"
  >ログイン</a>
</div>
@endsection


