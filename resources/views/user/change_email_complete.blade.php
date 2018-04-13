@extends('layout.app.master')

@section('content')
<div class="contentBody">
  <div class="contentBody__section">
    <h1 class="pageTitle">メールアドレスの変更完了</h1>
    <p>
      ご入力いただいたメールアドレスへの変更が完了しました。<br>
      改めてログインしてください。<br>
      現在のご登録メールアドレス：<strong>{{ $new_email ?? '' }}</strong>
    </p>
  </div>
</div>
<div class="contentFooter">
  <a class="btn"
    href="/user/login"
    data-color="white"
    data-block="true"
  >ログイン</a>
</div>
@endsection

@section('script')
<script>
(function() {
  // ログアウト処理
  vm.$store.dispatch('LOGOUT');
})();
</script>
@endsection
