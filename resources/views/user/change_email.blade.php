@extends('layout.app.master')
@section('content')


<section class="second-space2">
<div class="content-space__second">
  <h1 class="title-sub outerside">メールアドレス変更</h1>
    <div class="form-register">

      @if ( $error_message ?? '' )<br><span class="text error">{{$error_title ?? ''}}&nbsp;{{$error_message}}</span><br><br>@endif


      @if (($method_type ?? '') == 'post' ) {{-- POST時表示内容 --}}

      <div class="form-complate">
        <div class="form-complate__message">
        ご入力いただいたメールアドレスに確認のメールを送信しました。<br>
        メールに記載されたURLにアクセスするとメールアドレスの変更処理を完了します。
        </div>
          <!-- <div class="form-submit__back">
            <a href="/user/mypage">マイページに戻る</a>
          </div> -->
      </div>

      @else {{-- GET時表示内容 --}}

      <div class="form-register__mailChange">
       <span>現在のメールアドレス</span>
       <p>{{$email ?? '' }}</p>
      </div>

      <form name="frm" action="/user/change_email" method="post">
          {{ csrf_field() }}
          <span>新しいメールアドレス入力</span>
          <input type="text" name="email" value="" class="form-register__input" placeholder="例）macomo@mamauranai.co.jp"/>
          <span>新しいメールアドレス(確認)</span>
          <input type="text" name="new_email" value="" class="form-register__input" placeholder="例）macomo@mamauranai.co.jp"/>
          <div class="button-default">
            <input type="submit" value="変更する">
          </div>
      </form>
    </div>
    <div class="page-back outerside"><a href="">戻る</a></div>
<!-- <br>
sns認証<br>
<br>
<br> -->

<!-- 最新のお知らせを受けとる: <br>
<br>
@if ( $mail_magazine ?? '' ) <br>
現在の設定：受け取る<br>
@else
現在の設定：受け取らない<br>
@endif -->

<!-- <br>
<form name="frm" action="/user/change_email" method="post">
    {{ csrf_field() }}
    <input name="change_mail_magazine" type="hidden" value="1" /><br>
    <input name="mail_magazine" value="1" type="radio" @if (($mail_magazine ?? '') == 1) checked @endif>受け取る &nbsp;
    <input name="mail_magazine" value="0" type="radio" @if (($mail_magazine ?? '') == 0) checked @endif>受け取らない
    <br>
    <br>
    <input type="submit" value="変更する">
</form> -->

    @endif

</div>
</div>
</section>













<!-- <div class="contentBody">
  <div class="contentBody__section">
    <h1 class="pageTitle">メールアドレスの変更</h1>

    @if ( $error_message ?? '' )<br><span class="text error">{{$error_title ?? ''}}&nbsp;{{$error_message}}</span><br><br>@endif


    @if (($method_type ?? '') == 'post' ) {{-- POST時表示内容 --}}

    <p>
      ご入力いただいたメールアドレスに確認のメールを送信しました。<br>
      メールに記載されたURLにアクセスするとメールアドレスの変更処理を完了します。
    </p>

    @else {{-- GET時表示内容 --}}

現在のメールアドレス: {{$email ?? '' }}<br>
<br>
<form name="frm" action="/user/change_email" method="post">
    {{ csrf_field() }}
    新しいメールアドレス<br>
    <input type="text" name="email" value="" /><br>
    <br>
    新しいメールアドレス(確認)<br>
    <input type="text" name="new_email" value="" /><br>
    <br>
    <input type="submit" value="変更する">
</form>

<br>
sns認証<br>
<br>
<br>

最新のお知らせを受けとる: <br>
<br>
@if ( $mail_magazine ?? '' ) <br>
現在の設定：受け取る<br>
@else
現在の設定：受け取らない<br>
@endif

<br>
<form name="frm" action="/user/change_email" method="post">
    {{ csrf_field() }}
    <input name="change_mail_magazine" type="hidden" value="1" /><br>
    <input name="mail_magazine" value="1" type="radio" @if (($mail_magazine ?? '') == 1) checked @endif>受け取る &nbsp;
    <input name="mail_magazine" value="0" type="radio" @if (($mail_magazine ?? '') == 0) checked @endif>受け取らない
    <br>
    <br>
    <input type="submit" value="変更する">
</form>



    @endif

  </div>
</div>


 -->






@endsection
