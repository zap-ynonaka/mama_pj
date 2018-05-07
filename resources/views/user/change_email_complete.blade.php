@extends('layout.app.master')

@section('content')


<section class="second-space2">
  <div class="content-space__second">
    <h1 class="title-sub outerside">メールアドレス変更完了</h1>
      <div class="form-register">
        <div class="form-complate">
          <div class="form-complate__message">
          ご入力いただいたメールアドレスへの変更が完了しました。
          </div>
          <div class="form-register__button">
            <a class="btn"
              href="/user/login"
              data-color="white"
              data-block="true"
            >ログインページへ</a>
          </div>
        </div>
      </div>
  </div>
</section>


<!-- <div class="contentBody">
  <div class="contentBody__section">
    <h1 class="pageTitle">メールアドレス変更完了</h1>
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
  >ログインページへ</a>
</div> -->
@endsection

@section('script')
<script>
(function() {
  // ログアウト処理
  vm.$store.dispatch('LOGOUT');
})();
</script>
@endsection
