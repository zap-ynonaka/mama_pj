@extends('layout.app.master')
@section('content')

  <section class="l-section">
    <div class="l-content">
      <h3>ログイン確認</h3>
      @include('layout.error_message')
      <div class="subheading">
        <span>メールアドレスでログイン</span>
      </div>
      <form method="post" class="o-formGroup" id="js-generalForm">
        {{ csrf_field() }}
        <input type="hidden" name="sns" value="none">
        <div class="m-formControl">
          <div class="m-formControl__field">
            <input type="email" name="email" id="email" class="a-input" placeholder="メールアドレスを入力" required>
          </div>
        </div>
        <div class="m-formControl">
          <div class="m-formControl__field">
            <input type="password" name="password" id="password" class="a-input" placeholder="パスワードを入力" required>
          </div>
        </div>
        <button type="submit" class="a-button a-button--block a-button--default">ログイン</button>
      </form>
      <small class="a-caption">パスワードをお忘れの場合は<a class="caution" href="reissue?{{$query_string ?? ''}}">再発行の手続き</a>よりパスワードの再発行を行ってください。</small>

      <div class="subheading">
        <span>以下のアカウントでログイン</span>
      </div>

      <div class="l-row socialButtonGroup" style="margin-bottom: 0; border-radius: 4px 4px 0 0;">
        <div class="sns-signin">
          <a href="https://auth.login.yahoo.co.jp/yconnect/v1/authorization?response_type=code&redirect_uri={{$yahooLoginUrl ?? ''}}&client_id={{$yahooAppId ?? ''}}&scope=openid+email&bail=1" class="socialButton">
            <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11295" alt="Yahoo!JAPAN IDでログイン" width="36" height="36"></div>
          </a>
        </div>

        <div class="sns-signin">
          <div scope="email" onclick="authenticateWithFacebook();" class="socialButton">
            <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11286" alt="Facebookでログイン" width="36" height="36"></div>
          </div>
        </div>

        <div class="sns-signin">
          <div onclick="location.href='/user/twitter_login'" class="socialButton">
            <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11294" alt="Twitterでログイン" width="36" height="36"></div>
          </div>
        </div>

        <div class="sns-signin">
          <div class="btn btn-google-plus g-signin" id="signinButton" data-callback="signinCallback" data-clientid="{{$googleplusClientId ?? ''}}" data-cookiepolicy="{{$g_cookiepolicy ?? ''}}" data-requestvisibleactions="http://schemas.google.com/AddActivity" data-scope="email">
            <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11287" alt="Googleでログイン" width="36" height="36"></div>
          </div>
        </div>

      </div>

    </div>
  </section>
  <div class="m-alert">
    <div class="l-content">
      <h6>はじめてご利用されるお客様はこちら</h6>
      <a class="a-button a-button--block a-button--accent" href="/user/regist_input?{{$query_string ?? ''}}">新規会員登録</a>
    </div>
  </div>


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
            form.submit();
          }
        );
      }
    }
  </script>


@endsection