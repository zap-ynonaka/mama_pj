@extends('layout.app.master')
@section('content')


<h2 class="title-second__base">ログイン</h2>

  <section class="second-space1">
  <div class="form-register content-space__second">

  <h2 class="title-sub outerside">メールアドレスでログイン</h2>
    @include('layout.error_message')
    <!-- <div class="subheading">
      <span>メールアドレスでログイン</span>
    </div> -->
    <form method="post" class="o-formGroup" id="js-generalForm">
      {{ csrf_field() }}
      <input type="hidden" name="sns" value="none">
      <div class="form-register__mail">
        <span>メールアドレス入力</span>
        <div class="m-formControl">
          <div class="m-formControl__field">
            <input type="email" name="email" id="email" class="form-register__input" placeholder="例）macomo@mamauranai.co.jp" required>
          </div>
        </div>
        <span>パスワード</span>
        <div class="m-formControl">
          <div class="m-formControl__field">
            <input type="password" name="password" id="password" class="form-register__input" placeholder="12345678" required>
          </div>
          <p class="a-caption"><a class="caution" href="reissue?{{$query_string ?? ''}}">パスワードを忘れた方</a></p>
          <div class="form-register__button">
            <button type="submit" class="">ログイン</button>
          </div>
        </div>
      </div>
      </form>


    <h2 class="title-sub outerside">ソーシャルアカウントでログイン</h2>

      <div class="form-register__social">
        <div class="form-register__socialWrapper g-icon">
          <div class="socialButton g-signin" id="signinButton" data-callback="signinCallback" data-clientid="{{$googleplusClientId ?? ''}}" data-cookiepolicy="{{$g_cookiepolicy ?? ''}}" data-requestvisibleactions="http://schemas.google.com/AddActivity" data-scope="email">
            <div class="form-register__socialImage"><img src="/images/icon_social/ico-google.png" alt="Googleでログイン"></div>
            <div class="form-register__socialtext">googleで登録</div>
          </div>
        </div>

        <div class="form-register__socialWrapper f-icon">
          <div scope="email" onclick="authenticateWithFacebook();" class="socialButton">
          <div class="form-register__socialImage"><img src="/images/icon_social/ico-facebook.png" alt="Facebookでログイン"></div>
          <div class="form-register__socialtext">facebookで登録</div>
          </div>
        </div>

        <div class="form-register__socialWrapper t-icon">
          <div onclick="location.href='/user/twitter_login'" class="socialButton">
          <div class="form-register__socialImage"><img src="/images/icon_social/ico-twitter.png" alt="Twitterでログイン"></div>
          <div class="form-register__socialtext">twitterで登録</div>
          </div>
        </div>

        <div class="form-register__socialWrapper y-icon">
          <a href="https://auth.login.yahoo.co.jp/yconnect/v1/authorization?response_type=code&redirect_uri={{$yahooLoginUrl ?? ''}}&client_id={{$yahooAppId ?? ''}}&scope=openid+email&bail=1" class="socialButton">
            <div class="form-register__socialImage"><img src="/images/icon_social/ico-yahoo.png" alt="Yahoo!JAPAN IDでログイン"></div>
            <div class="form-register__socialtext">Yahoo!で登録</div>
          </a>
        </div>

      </div>

  <div class="m-alert">
    <div class="form-register__login outerside">
      <h2 class="title-sub">新規登録はこちら</h2>
      <div class="button-default">
        <a class="a-button a-button--block a-button--accent" href="/user/regist_input?{{$query_string ?? ''}}">新規登録ページへ</a>
      </div>
    </div>
  </div>

  <div class="page-back outerside"><a href="">戻る</a></div>

</div>
</section>


  <script type="application/json" id="json-data">
    {
      "callback_url": "{{$callback_url ?? ''}}",
      "facebookAppId": "{{$facebookAppId ?? ''}}",
      "facebookAppVersion": "{{$facebookAppVersion ?? ''}}",
      "query_string": "{{$query_string ?? ''}}",
      "flash_message": "{{$flash_message ?? ''}}"
    }
  </script>
  <script>
    var data = JSON.parse(document.getElementById('json-data').textContent);

    window.fbAsyncInit = function() {
      FB.init({
        appId      : data.facebookAppId,
        cookie     : true,  // enable cookies to allow the server to access
        xfbml      : true,  // parse social plugins on this page
        version    : data.facebookAppVersion, // use version {$facebookAppVersion}
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

    function authenticateWithFacebook() {
      FB.login(function(response1) {
        if (response1.status === 'connected') {
          FB.api('/me', {fields: 'email'}, function(response2) {
            var form = document.createElement('form');
            form.setAttribute('method', 'post');
            form.style.display = 'none';
            document.body.appendChild(form);
            var typeInput = document.createElement('input');
            typeInput.setAttribute('type', 'hidden');
            typeInput.setAttribute('name', 'sns');
            typeInput.setAttribute('value', 'facebook');
            form.appendChild(typeInput);
            var userIdInput = document.createElement('input');
            userIdInput.setAttribute('type', 'hidden');
            userIdInput.setAttribute('name', 'user_id');
            userIdInput.setAttribute('value', response1.authResponse.userID);
            form.appendChild(userIdInput);
            var accessTokenInput = document.createElement('input');
            accessTokenInput.setAttribute('type', 'hidden');
            accessTokenInput.setAttribute('name', 'access_token');
            accessTokenInput.setAttribute('value', response1.authResponse.accessToken);
            form.appendChild(accessTokenInput);
            var queryStringInput = document.createElement('input');
            queryStringInput.setAttribute('type', 'hidden');
            queryStringInput.setAttribute('name', 'query_string');
            queryStringInput.setAttribute('value', data.query_string);
            form.appendChild(queryStringInput);
            var tokenInput = document.createElement('input');
            tokenInput.setAttribute('type', 'hidden');
            tokenInput.setAttribute('name', '_token');
            tokenInput.setAttribute('value', Laravel.csrfToken);
            form.appendChild(tokenInput);
            form.submit();
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
        var profileUrl = 'https://www.googleapis.com/plus/v1/people/me?access_token=' + authResult['access_token'] + "&scope=email";
        $.getJSON(
          profileUrl,
          {
            format: "json"
          },
          function(profile) {
            var form = document.createElement('form');
            form.setAttribute('method', 'post');
            form.style.display = 'none';
            document.body.appendChild(form);
            var typeInput = document.createElement('input');
            typeInput.setAttribute('type', 'hidden');
            typeInput.setAttribute('name', 'sns');
            typeInput.setAttribute('value', 'google');
            form.appendChild(typeInput);
            var userIdInput = document.createElement('input');
            userIdInput.setAttribute('type', 'hidden');
            userIdInput.setAttribute('name', 'user_id');
            userIdInput.setAttribute('value', profile.id);
            form.appendChild(userIdInput);
            var accessTokenInput = document.createElement('input');
            accessTokenInput.setAttribute('type', 'hidden');
            accessTokenInput.setAttribute('name', 'access_token');
            accessTokenInput.setAttribute('value', authResult['access_token']);
            form.appendChild(accessTokenInput);
            var queryStringInput = document.createElement('input');
            queryStringInput.setAttribute('type', 'hidden');
            queryStringInput.setAttribute('name', 'query_string');
            queryStringInput.setAttribute('value', data.query_string);
            form.appendChild(queryStringInput);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var tokenInput = document.createElement('input');
            tokenInput.setAttribute('type', 'hidden');
            tokenInput.setAttribute('name', '_token');
            tokenInput.setAttribute('value', CSRF_TOKEN);
            form.appendChild(tokenInput);

            form.submit();
          }
        );
      }
    }
  </script>


@endsection