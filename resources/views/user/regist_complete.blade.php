@extends('layout.app.master')
@section('content')

<section class="second-space2">
<div class="register-complete content-space__second">
  <h2 class="title-sub outerside">登録完了</h2>
  <ul class="form-register__navi">
        <li><img src="/images/regist/step-1-off.png" alt=""></li>
        <li><img src="/images/regist/step-2-off.png" alt=""></li>
        <li><img src="/images/regist/step-3-on.png" alt=""></li>
  </ul>
  <p>
  登録が完了しました。<br>
  まずはあなたのプロフィールを登録しましょう。
  </p>
  <div class="button-default">
    <a href="/user/my_profile">プロフィールを登録する</a>
  </div>

</div>
</section>

@endsection


<!-- <div style="display:none;">
  <div class="l-content card-complate u-text-center">
  <h3>{{$email ?? ''}}</h3>
  <br>
  <span class="common-color-01">メールアドレス、パスワードの登録が完了しました</span><br>
  <br>
    さっそく占う！<br>
    <a href="/user/my_profile"><span>プロフィール登録へ&nbsp;></span></a>
  </div>
</div> -->