@extends('layout.app.master')
@section('content')


<!-- <script>
  $(function() {
    $('.accordion-btn').on('click',function () {
      $(this).next('.accordion-area').slideToggle();
      $(this).toggleClass('accordion-off');
    });

    $('#show-pass').on('click', function() {
      if ($('#password').get(0).type === 'password'){
        $('#password').get(0).type = 'text';
        $('#pass-area label').removeClass('common-bg-01');
      } else {
        $('#password').get(0).type = 'password';
        $('#pass-area label').addClass('common-bg-01');
      }
    });

    $('#show-pass2').on('click', function() {
      if ($('#password2').get(0).type === 'password'){
        $('#password2').get(0).type = 'text';
        $('#pass-area label').removeClass('common-bg-02');
      } else {
        $('#password2').get(0).type = 'password';
        $('#pass-area label').addClass('common-bg-02');
      }
    });

    $('button.submit').on('click', function() {
      $('#password').get(0).type = 'password';
    });
    $('button.submit').on('click', function() {
      $('#password2').get(0).type = 'password';
    });

    $('#receive-btn').on('click', function() {
      $('.mail_mag-checkbox').toggleClass('active');
    });
  });
</script> -->

<section class="second-space1">
  <h2 class="title-second__base">新規登録</h2>
  <div class="content-space__top yellowStripe">
    <div class="content-catch child1">
      <h3>無料のユーザー登録で</h3>
      <span class="content-catch__discription">子どものその日の気分がわかる！<br>
        占い結果を保存できる！<br>
        誕生日などの再入力が不要！</sp>
      </span>
    </div>
  </div>
<!-- </section>

<section> -->
  <h2 class="title-sub">メールアドレスで登録</h2>
  <div class="form-register content-space__second">
    <ul class="form-register__navi">
      <li><img src="/images/regist/step-1-on.png" alt=""></li>
      <li><img src="/images/regist/step-2-off.png" alt=""></li>
      <li><img src="/images/regist/step-3-off.png" alt=""></li>
    </ul>
  <div>

<form id="js-generalForm" method="post" action="/user/regist_mailsend">
    {{ csrf_field() }}
    <input type="hidden" name="sns" value="{{$sns ?? 'none'}}">
    <input type="hidden" name="twitter_id" value="{{$twitter_id ?? ''}}">
    <input type="hidden" name="facebook_id" value="{{$facebook_id ?? ''}}">
    <input type="hidden" name="google_id" value="{{$google_id ?? ''}}">
    <input type="hidden" name="yahoo_id" value="{{$yahoo_id ?? ''}}">

  @if ( $notSend ?? '' != 1)
  <div class="form-register__mail">
    <span>メールアドレス入力</span>
    <input id="email" type="email" value="{{$email ?? ''}}" name="email" class="form-register__input" placeholder="例）macomo@mamauranai.co.jp"/>
    <input id="email_e" type="hidden" name="email_e" value="" />
    <p>利用規約およびプライバシーポリシーに同意のうえ会員登録方法をお選びください。</p>
    <div id="error-email"></div>

    <div>
      <span>パスワード設定</span>
      <div id="">
        <input type="password" id="password" name="password" class="form-register__input" placeholder="例）macomo@mamauranai.co.jp" required>
        <!-- <input id="show-pass" type="checkbox" /><label for="show-pass" class="common-bg-01">パスワードを<br>表示</label></div> -->
        <div id="error-password"></div>

        <!-- <ul class="a-caption common-color-02">
        <li>半角英数字8文字以上で登録してください。</li>
        <li>次回ログイン時に利用しますので大切に保管してください。</li></ul> -->
      </div>
       <!-- <p class="mail_mag-checkbox active"><input name="mail_mag" id="receive-btn" type="checkbox" value="1" checked/><label for="receive-btn">最新情報を受け取る</label></p> -->
      @endif
      <input type="hidden" name="query_string" value="{$query_string}">
      @if (isset($query_string_array)) @foreach ($query_string_array as $k => $v)
      <input type="hidden" name="{{$k ?? ''}}" value="{{$v ?? ''}}" />
      @endforeach @endif

      <div class="form-register__button">
        <button type="submit" class="" onclick="document.forms[0].elements['email_e'].value=encodeURIComponent(document.forms[0].elements['email'].value);">
      @if ( $notSend ?? '' != 1)
          <div class="submit-btn">確認メールを送信</div>
      @endif
        </button>
      </div>
    </div>
  </div>
</form>



@if ( $error_message ?? '' )<span class="text error">{{$error_message}}</span><br>@endif

<!-- </section> -->



<!-- <section class="l-section"> -->
  <!-- <div class="l-content"> -->
    <!-- <h3>会員登録</h3> -->
    <!-- <div class="stepbar">
      <img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart-srv%2fimage%3fid%3d11310%22%3E">
    </div> -->

    <!-- @if ( $error_message ?? '' )<span class="text error">{{$error_message}}</span><br>@endif -->

    <!-- <h6 class="common-color-01">{{$name ?? ''}}</h6>
    <p class="a-caption"><a class="common-color-02" href="/help/terms">利用規約</a>および<a class="common-color-02" href="http://www.zappallas.com/etc/">プライバシーポリシー</a>に同意のうえ会員登録の方法をお選びください。</p> -->


    @if (($sns ?? '') == 'yahoo')
      <div class="socialButton-area accordion-btn">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11295" alt="Yahoo!JAPAN IDでログイン" width="36" height="36"></div>
        <div>yahoo!IDと連携</div></div>
    @elseif (($sns ?? '') == 'google')
      <div class="socialButton-area accordion-btn">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11287" alt="Googleでログイン" width="36" height="36"></div>
        <div>googleと連携</div></div>
    @elseif (($sns ?? '') == 'facebook')
      <div class="socialButton-area accordion-btn">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11286" alt="Facebookでログイン" width="36" height="36"></div>
        <div>facebookと連携</div></div>
    @elseif (($sns ?? '') == 'twitter')
      <div class="socialButton-area accordion-btn">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11294" alt="Twitterでログイン" width="36" height="36"></div>
        <div>twitterと連携</div></div>
    @endif


    <!-- <div class="subheading">
      <span>メールアドレスで会員登録</span>
    </div> -->

    <!-- <div class="accordion-btn accordion-off">
      <div class="socialButton__image"><i class="material-icons" style="color: #AAA;line-height:44px;">&#xE0BE;</i></div>
      <span>メールアドレス・パスワード入力</span>
    </div> -->

    <!-- <div class="accordion-area" style="display: none;"> -->
      <!-- <form id="js-generalForm" method="post" action="/user/regist_mailsend">
        {{ csrf_field() }}
        <input type="hidden" name="sns" value="{{$sns ?? 'none'}}">
        <input type="hidden" name="twitter_id" value="{{$twitter_id ?? ''}}">
        <input type="hidden" name="facebook_id" value="{{$facebook_id ?? ''}}">
        <input type="hidden" name="google_id" value="{{$google_id ?? ''}}">
        <input type="hidden" name="yahoo_id" value="{{$yahoo_id ?? ''}}">

        @if ( $notSend ?? '' != 1)
        <div>
          <span>メールアドレスはログインIDとして利用します。</span>
          <input id="email" type="email" value="{{$email ?? ''}}" name="email" class="a-input inputtext" />
          <input id="email_e" type="hidden" name="email_e" value="" />
          <div id="error-email"></div>

        <div>
          <span>登録するパスワードを入力してください</span>
          <div id="pass-area">
            <input type="password" id="password" name="password" class="a-input" required>
            <input id="show-pass" type="checkbox" /><label for="show-pass" class="common-bg-01">パスワードを<br>表示</label></div>
          <div id="error-password"></div>

          <ul class="a-caption common-color-02">
            <li>半角英数字8文字以上で登録してください。</li>
            <li>次回ログイン時に利用しますので大切に保管してください。</li></ul>
        </div>
        <p class="mail_mag-checkbox active"><input name="mail_mag" id="receive-btn" type="checkbox" value="1" checked/><label for="receive-btn">最新情報を受け取る</label></p>
        @endif
        <input type="hidden" name="query_string" value="{$query_string}">
        @if (isset($query_string_array)) @foreach ($query_string_array as $k => $v)
        <input type="hidden" name="{{$k ?? ''}}" value="{{$v ?? ''}}" />
        @endforeach @endif

        <div class="l-row__item--stretch">
          <button type="submit" class="submit common-bg-01" onclick="ga('send', 'event', 'cv2', 'click', '{{$name ?? ''}}/メールアドレス', true);document.forms[0].elements['email_e'].value=encodeURIComponent(document.forms[0].elements['email'].value);">
        @if ( $notSend ?? '' != 1)
            <div class="submit-btn">確認メール送信</div>
        @endif
          </button>
        </div>
      </form> -->
    <!-- </div> -->

    @if (($sns ?? '') == 'none' || ($sns ?? '') == '')

    <h2 class="title-sub outerside">ソーシャルアカウントで登録</h2>

<div class="form-register__social">
  <div class="form-register__socialWrapper g-icon g-signin" id="signinButton" data-callback="signinCallback" data-clientid="{{$googleplusClientId ?? ''}}" data-cookiepolicy="{{$g_cookiepolicy ?? ''}}" data-requestvisibleactions="http://schemas.google.com/AddActivity" data-scope="email">
    <div class="form-register__socialImage"><img src="/images/icon_social/ico-google.png" alt="Googleでログイン"></div>
    <div class="form-register__socialtext">googleで登録</div>
  </div>

  <div class="form-register__socialWrapper f-icon" scope="email" onclick="authenticateWithFacebook();">
    <div class="form-register__socialImage"><img src="/images/icon_social/ico-facebook.png" alt="Facebookでログイン"></div>
    <div class="form-register__socialtext">facebookで登録</div>
  </div>

  <div class="form-register__socialWrapper t-icon" onclick="authenticateWithTwitter();">
    <div class="form-register__socialImage"><img src="/images/icon_social/ico-twitter.png" alt="Twitterでログイン"></div>
    <div class="form-register__socialtext">twitterで登録</div>
  </div>

  <div class="form-register__socialWrapper y-icon">
    <a href="https://auth.login.yahoo.co.jp/yconnect/v1/authorization?response_type=code&redirect_uri={{$yahooRegisterUrl ?? ''}}&client_id={{$yahooAppId ?? ''}}&scope=openid+email&bail=1">
      <div class="form-register__socialImage"><img src="/images/icon_social/ico-yahoo.png" alt="Yahoo!JAPAN IDでログイン"></div></a>
      <div class="form-register__socialtext">Yahoo!で登録</div>
  </div>
</div>
@endif

  <!-- </div> -->
<div class="form-register__login outerside">
    <h2 class="title-sub">すでにアカウントをお持ちの方はこちら</h2>
    <div class="button-default">
      <a href="/user/login?{{$login_query_string ?? ''}}" class="">ログインページへ</a>
    </div>
</div>

<div class="page-back outerside"><a href="">戻る</a></div>

</section>




<!--cocoloni_1-33_END-->
<script type="application/json" id="json-data">
  {
    "name": "{{$name ?? ''}}",
    "facebookAppId": "{{$facebookAppId ?? ''}}",
    "facebookAppVersion": "{{$facebookAppVersion ?? ''}}"
  }
</script>

<script>
  var data = JSON.parse(document.getElementById('json-data').textContent);
  window.fbAsyncInit = function() {
    FB.init({
      appId      : data.facebookAppId,
      cookie     : true,  // enable cookies to allow the server to access
      xfbml      : true,  // parse social plugins on this page
      version    : data.facebookAppVersion // use version 2.6
    });
  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/ja_JP/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // GoogleAnalytics event関数追加
  function authenticateWithTwitter() {
//    ga('send', 'event', 'cv2', 'click', data.name + '\/twitter', true);
    location.href = '/user/twitter_register';
  }

  function authenticateWithFacebook() {
    // GoogleAnalytics event関数追加
//    ga('send', 'event', 'cv2', 'click', data.name + '\/facebook', true);

    FB.login(function(response1) {
      if (response1.status === 'connected') {
        FB.api('/me', {fields: 'email'}, function(response2) {
          if (!response2.email) {
            alert('メールアドレスを取得できませんでした。');
            return;
          }
          if (!response2.id) {
            alert('facebookIDを取得できませんでした。');
            return;
          }
          var redirectUrl = '/user/regist_input' + location.search + (location.search ? '&' : '?') + 'email=' + response2.email + '&sns=facebook' + '&facebook_id=' + response2.id;
          if (document.referrer) {
            var referrer = "referrer=" + encodeURIComponent(document.referrer);
            redirectUrl = redirectUrl + '&' + referrer;
          }
          location.href = redirectUrl;
        });
      }
    }, {scope: 'email'});
  }

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/client:plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();

  function signinCallback(authResult) {
      if (authResult['access_token'] && authResult['status'].method == 'PROMPT') {
      var profileUrl = 'https://www.googleapis.com/plus/v1/people/me?access_token=' + authResult['access_token'];
      $.getJSON(
        profileUrl,
        {
          format: "json"
        },
        function(profile) {
          var redirectUrl = '/user/regist_input' + location.search + (location.search ? '&' : '?') + 'email=' + profile.emails[0].value + '&google_id=' + profile.id + '&sns=google';
          if (document.referrer) {
            var referrer = "referrer=" + encodeURIComponent(document.referrer);
            redirectUrl = redirectUrl + '&' + referrer;
          }
          location.href = redirectUrl;
        }
      );
    } else if (authResult['error']) {
      console.log(authResult);
    }
  }
</script>


@endsection