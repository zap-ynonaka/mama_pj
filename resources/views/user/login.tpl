{if $newAuth}<!-- 旧FW新認証 -->
{include file='../include/header_new_auth.tpl'}
{include file='../include/common.tpl'}

  <center><div class="loading">{if $callback_url}<p class="textCenter"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></p>{/if}</div></center>
  <script>
  {if $callback_url}
    location.href = '{$callback_url}';
  {/if}
  {literal}
    window.fbAsyncInit = function() {
      FB.init({
  {/literal}
        appId      : '{$facebookAppId}',
  {literal}
        cookie     : true,  // enable cookies to allow the server to access
                            // the session
        xfbml      : true,  // parse social plugins on this page
  {/literal}
        version    : '{$facebookAppVersion}' // use version {$facebookAppVersion}
  {literal}
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
  {/literal}
              queryStringInput.setAttribute('value', '{$query_string}');
  {literal}
              form.appendChild(queryStringInput);
              form.submit();
            });
          }
      }, {scope: 'email'});
    }
  {/literal}

  {literal}
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
  {/literal}
              queryStringInput.setAttribute('value', '{$query_string}');
  {literal}
              form.appendChild(queryStringInput);
              form.submit();
          }
      );
    }
  }
  {/literal}

  </script>

<div class="btnBlock">

{if $flash_message}
<p class="text error">{$flash_message}</p>
{/if}

{if !$service_unknown}{* service_code無い場合、非表示 *}
{if $newAuth}
<!-- 星読みクレカ用実装確認-->
<div class="billingtitle2">
  携帯電話会社のIDでログイン
</div>
  <a href="{$docomo_url}" class="btn"><img src="https://websmart.zappallas.com/web_image?url=http%3A%2F%2Fwebpayment.smart-srv%2Fimage%3Fid%3D11236" alt="docomo  ログイン" class="carrierLogo"/></a>
  <a href="{$au_url}" class="btn"><img src="https://websmart.zappallas.com/web_image?url=http%3A%2F%2Fwebpayment.smart-srv%2Fimage%3Fid%3D11235" alt="au ID ログイン" class="carrierLogo"/></a>
  <a href="{$softbank_url}" class="btn"><img src="https://websmart.zappallas.com/web_image?url=http%3A%2F%2Fwebpayment.smart-srv%2Fimage%3Fid%3D11237" alt="SoftBank ログイン" class="carrierLogo" /></a>
<br>
{/if}
<aside class="textCenter">
    <a class="asideLink" href="https://websmart.zappallas.com/web_u_pay/login/help">
       IDを持っていない<br>わからない方はこちら
    </a>
</aside>

<hr class="hr-text" data-content="OR">
<div class="billingtitle2">
  メールアドレスでログイン
</div>

<form method="post">
        <input type="hidden" name="sns" value="none" />
	<p><input type="email" name="email" class="inputtext" placeholder="メールアドレスを入力" /></p>
	<p><input type="password" name="password" class="inputtext" placeholder="パスワードを入力" /></p>
        <input type="hidden" name="query_string" value="{$query_string}" />
	<p><input type="submit" class="btn" value="送信" /></p>
</form>
{/if}
{if $error_message}
<p class="text error">{$error_title}{$error_message}</p>
{/if}

</div>

{if !$service_unknown}{* service_code無い場合、非表示 *}
<aside class="textCenter">
    <a class="asideLink" href="reissue?{$reissue_query_string}">
       パスワードを<br>忘れた方はこちら
    </a>
</aside>

<div class="btnBlock">
  <hr class="hr-text" data-content="OR">
  <div class="billingtitle2">
    ソーシャルアカウントでログイン
  </div>

<div class="textCenter"><a href="https://auth.login.yahoo.co.jp/yconnect/v1/authorization?response_type=code&redirect_uri={$yahooLoginUrl}&client_id={$yahooAppId}&scope=openid+email&bail=1"><img src="/img/btnSYid.gif" alt="Yahoo!JAPAN IDでログイン" /></a></div>
<button class="btn btn-facebook" onClick="authenticateWithFacebook();"><i class="fa fa-facebook"></i> | Facebook</button>
<button class="btn btn-google-plus g-signin" id="signinButton" data-callback="signinCallback" data-clientid="{$googleplusClientId}" data-cookiepolicy="{$g_cookiepolicy}" data-requestvisibleactions="http://schemas.google.com/AddActivity" data-scope="email">
<i class="fa fa-google-plus"></i> | Google plus</button>

<button class="btn btn-twitter" onClick="location.href='/web_u_pay/authentication/twitter_login'"><i class="fa fa-twitter"></i> | Twitter</button>

</div>

<div class="btnBlock">
  <a href="/Registandpayment/register?{$register_query_string}" class="btn">会員登録はこちら</a>
</div>
{/if}

{include file='../include/footer_new_auth.tpl'}
{else}

{ * START : 新FW新認証テンプレート * }
{include file='../include/_PLUS_header.tpl'}
{include file='../include/common.tpl'}
  {if $callback_url}
  <div class="loader">
    <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
  </div>
  {else}
  <section class="l-section">
    <div class="l-content">
      <h3>{$title}</h3>
      {include file='../include/error_message.tpl'}
      {if !$service_unknown}{* service_code無い場合、非表示 *}
      <div class="subheading">
        <span>メールアドレスでログイン</span>
      </div>
      <form method="post" class="o-formGroup" id="js-generalForm">
        <input type="hidden" name="sns" value="none">
        <input type="hidden" name="query_string" value="{$query_string}">
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
      <small class="a-caption">パスワードをお忘れの場合は<a class="caution" href="reissue?{$reissue_query_string}">再発行の手続き</a>よりパスワードの再発行を行ってください。</small>

      <div class="subheading">
        <span>以下のアカウントでログイン</span>
      </div>

      <div class="l-row socialButtonGroup" style="margin-bottom: 0; border-radius: 4px 4px 0 0;">
        <div class="sns-signin">
          <a href="https://auth.login.yahoo.co.jp/yconnect/v1/authorization?response_type=code&redirect_uri={$yahooLoginUrl}&client_id={$yahooAppId}&scope=openid+email&bail=1" class="socialButton">
            <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11295" alt="Yahoo!JAPAN IDでログイン" width="36" height="36"></div>
          </a>
        </div>

        <div class="sns-signin">
          <div scope="email" onclick="authenticateWithFacebook();" class="socialButton">
            <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11286" alt="Facebookでログイン" width="36" height="36"></div>
          </div>
        </div>

        <div class="sns-signin">
          <div onclick="location.href='/web_u_pay/authentication/twitter_login'" class="socialButton">
            <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11294" alt="Twitterでログイン" width="36" height="36"></div>
          </div>
        </div>

        <div class="sns-signin">
          <div class="btn btn-google-plus g-signin" id="signinButton" data-callback="signinCallback" data-clientid="{$googleplusClientId}" data-cookiepolicy="{$g_cookiepolicy}" data-requestvisibleactions="http://schemas.google.com/AddActivity" data-scope="email">
            <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11287" alt="Googleでログイン" width="36" height="36"></div>
          </div>
        </div>

      </div>
      {/if}

    </div>
  </section>
  {if !$service_unknown && $servi_code != '0000_0809_1001'}{* service_code無い場合かクローズサイトの場合、非表示 *}
  <div class="m-alert">
    <div class="l-content">
      <h6>はじめてご利用されるお客様はこちら</h6>
      <a class="a-button a-button--block a-button--accent" href="/authentication/register?{$register_query_string}">新規会員登録</a>
    </div>
  </div>
  {/if}

  {/if}

  <script type="application/json" id="json-data">
    {literal}
    {
    {/literal}
      "callback_url": "{$callback_url}",
      "facebookAppId": "{$facebookAppId}",
      "facebookAppVersion": "{$facebookAppVersion}",
      "query_string": "{$query_string}",
      "flash_message": "{$flash_message}"
    {literal}
    }
    {/literal}
  </script>

  <script>
    {literal}
    var data = JSON.parse(document.getElementById('json-data').textContent);

    if (data.callback_url) {
      location.href = data.callback_url;
    }

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
    {/literal}
  </script>

{include file='../include/_PLUS_footer.tpl'}
{* END :  新FW新認証テンプレート *}

{/if}
