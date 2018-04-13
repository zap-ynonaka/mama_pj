{if $newAuth}<!-- 旧FW新認証 -->
{include file='../include/header_new_auth.tpl'}
{include file='../include/common.tpl'}

  <script>
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
        version    : '{$facebookAppVersion}' // use version 2.6
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
            FB.api('/me', {fields: 'id,email'}, function(response2) {
              if (!response2.email) {
                alert('メールアドレスを取得できませんでした。');
                return;
              }
              if (!response2.id) {
                alert('facebookIDを取得できませんでした。');
                return;
              }
              var redirectUrl = '/web_u_pay/authentication/mail_check' + location.search + (location.search ? '&' : '?') + 'email=' + response2.email + '&sns=facebook'+ '&facebook_id=' + response2.id;
              if (document.referrer) {
                var referrer = "referrer=" + encodeURIComponent(document.referrer);
                redirectUrl = redirectUrl + '&' + referrer;
              }
              location.href = redirectUrl;
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
      var profileUrl = 'https://www.googleapis.com/plus/v1/people/me?access_token=' + authResult['access_token'] ;
      $.getJSON(
          profileUrl,
          {
              format: "json"
          },
          function(profile) {
              var redirectUrl = '/web_u_pay/authentication/mail_check' + location.search + (location.search ? '&' : '?') + 'email=' + profile.emails[0].value + '&google_id=' + profile.id + '&sns=google';
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

  {/literal}
  </script>
<div class="billingtitle1">携帯電話会社のIDで登録</div>
<h1><img src="/assets/image/regin-img.png" alt="月額入会開始" width="100%"></h1>
<div class="btnBlock">
    <p style="font-weight: bold" class="textCenter">月額 {$price}円 (税込)</p>
    <a href="{$docomo_url}" class="btn"><img src="https://websmart.zappallas.com/web_image?url=http%3A%2F%2Fwebpayment.smart-srv%2Fimage%3Fid%3D11236" alt="docomo  ログイン" class="carrierLogo"/></a>
    <a href="{$au_url}" class="btn"><img src="https://websmart.zappallas.com/web_image?url=http%3A%2F%2Fwebpayment.smart-srv%2Fimage%3Fid%3D11235" alt="au ID ログイン" class="carrierLogo"/></a>
    <a href="{$softbank_url}" class="btn"><img src="https://websmart.zappallas.com/web_image?url=http%3A%2F%2Fwebpayment.smart-srv%2Fimage%3Fid%3D11237" alt="SoftBank ログイン" class="carrierLogo" /></a>
    <br>
    <aside class="textCenter">
      <a class="asideLink" href="https://websmart.zappallas.com/web_u_pay/login/help">
        IDを持っていない<br>わからない方はこちら
      </a>
    </aside>

    <hr class="hr-text" data-content="OR">
    <div class="billingtitle2">メールアドレスで登録<span>決済にはクレジットカードが必要となります</span></div>
    <ol class="stepBar step4">
      <li class="step current"><img src="/img/step01.png" alt="認証方法選択" /></li>
      <li class="step"><img src="/img/step02.png" alt="メール送信" /></li>
      <li class="step"><img src="/img/step03.png" alt="メール送信完了" /></li>
      <li class="step"><img src="/img/step04.png" alt="パスワード設定" /></li>
    </ol>

    <p style="font-weight: bold" class="textCenter">月額 {$price}円 (税込)</p>
    <p class="text textCenter">メールで会員登録 ｜ <a href="#sns">SNSで登録</a></p>

    <form action="/authentication/mail_check" method="post">
      <input type="hidden" name="sns" value="none" />
      <input type="hidden" name="query_string" value="{$query_string}">
      <p><input type="email" value="" name="email" class="inputtext" placeholder="sample@yahoo.co.jp" /></p>

      <span>登録するパスワードを入力してください</span>
      <input type="password" id="password" name="password">

      {foreach from=$query_string_array item=value key=key}
      <input type="hidden" name="{$key}" value="{$value}">
      {/foreach}
      <p><input type="submit" class="btn" value="確認" /></p>
    </form>

    <h2 class="subhead">ドメイン指定受信をされているお客様</h2>
    <span style="font-weight:bold;line-height:1.4">迷惑メールフォルダにメールが届く可能性がございますので届かない場合は迷惑メールフォルダをご確認ください。</span>
    <p class="text">「zappallas.com」「cardservice.co.jp」ドメインからのメールを、受信可能に設定頂きますようお願い致します。（@を含めずにご登録下さい）<br>また、URL付きのメール・パソコンからのメールを拒否されている場合は、メールが届かない場合がございますので、併せてご確認下さいませ</p>
    <h2 class="subhead">メールアドレス・SNSアカウント登録時のご注意</h2>
    <p class="text">メールアドレス・SNSアカウントでご登録される場合、お支払いはクレジットカード（Visa/Master、JCB/AMEX）でのご登録をお願いいたします。</p>

    <p class="text textCenter" id="sns">ソーシャルアカウントで会員登録</p>

    <div class="textCenter"><a href="https://auth.login.yahoo.co.jp/yconnect/v1/authorization?response_type=code&redirect_uri={$yahooRegisterUrl}&client_id={$yahooAppId}&scope=openid+email&bail=1"><img src="/img/btnSYid.gif" alt="Yahoo!JAPAN IDで会員登録" /></a></div>
    <button class="btn btn-facebook" scope="email" onclick="authenticateWithFacebook();">
      <i class="fa fa-facebook"></i> | Facebook
    </button>
    <button class="btn btn-google-plus g-signin" id="signinButton" data-callback="signinCallback" data-clientid="{$googleplusClientId}" data-cookiepolicy="{$g_cookiepolicy}" data-requestvisibleactions="http://schemas.google.com/AddActivity" data-scope="email">
      <i class="fa fa-google-plus"></i> | Google plus
    </button>
    <button class="btn btn-twitter" onclick="location.href='/web_u_pay/authentication/twitter_register'">
      <i class="fa fa-twitter"></i> | Twitter
    </button>
  </div>
</div>

<div class="btnBlock">
  <a href="/authentication/login?{$login_query_string}" class="btn">ログインはこちら</a>
</div>

<div class="btnBlock">
  <a href="{$content_url}" class="btn">「{$name}」へ</a>
</div>

{include file='../include/footer_new_auth.tpl'}

{else}<!-- 新FW新認証 -->

{* START :  新FW新認証テンプレート *}
{include file='../include/_PLUS_header.tpl'}
{include file='../include/common.tpl'}
<script>
  {literal}
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

    // $('#email').on('blur',function(){
    //   if ($('#email').hasClass('valid')) {
    //     $('#error-email').addClass('check');
    //   } else {
    //     $('#error-email').removeClass('check');
    //   }
    // });

    // $('#password').on('blur',function(){
    //   if ($('#password').hasClass('valid')) {
    //     $('#error-password').addClass('check');
    //   } else {
    //     $('#error-password').removeClass('check');
    //   }
    // });

  });
  {/literal}
</script>

<section class="l-section">
  <div class="l-content">
    <h3>{$title}</h3>
    <div class="stepbar">
      <img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart-srv%2fimage%3fid%3d11310%22%3E">
    </div>
    {include file='../include/error_message.tpl'}
    <h5 class="u-text-left">月額{$price}円(税込)</h5>
    <h6 class="common-color-01">{$name}</h6>
    {if $serviceCode == '0829_1001' || $serviceCode == '0000_0829_1001'}
    <img src="https://websmart.zappallas.com/web_image?url=http%3A%2F%2Fwebpayment.smart-srv%2Fimage%3Fid%3D11337" alt="コーヒー1杯の値段でいつでもどこでも時間を気にせず毎日占い放題" class="cafecaption" style="width: 100%;margin: 5px 0px;" />
    {/if}
    <p class="a-caption"><a class="common-color-02" href="{$content_url}/help/terms">利用規約</a>および<a class="common-color-02" href="http://www.zappallas.com/etc/?WEBSMARTOUT=1">プライバシーポリシー</a>に同意のうえ会員登録の方法をお選びください。</p>


    <div class="subheading">
      <span>メールアドレスで会員登録</span>
    </div>

    <div class="accordion-btn accordion-off">
      <div class="socialButton__image"><i class="material-icons" style="color: #AAA;line-height:44px;">&#xE0BE;</i></div>
      <span>メールアドレス・パスワード入力</span>
    </div>

    <div class="accordion-area" style="display: none;">
      <form id="js-generalForm" action="/authentication/mail_check" method="post">
        {if $notSend != 1}
        <div>
          <span>メールアドレスはログインIDとして利用します。</span>
          <input id="email" type="email" value="{$email}" name="email" class="a-input inputtext" />
          <input id="email_e" type="hidden" name="email_e" value="" />
          <div id="error-email"></div>
          {if $error_message }<span class="text error">{$error_message}</span>{/if}</div>

        <div>
          <span>登録するパスワードを入力してください</span>
          <div id="pass-area">
            <input type="password" id="password" name="password" class="a-input" required>
            <input id="show-pass" type="checkbox" /><label for="show-pass" class="common-bg-01">パスワードを<br>表示</label></div>
          <div id="error-password"></div>
            {if $error_message }<span class="text error">{$error_message}</span>{/if}

          <ul class="a-caption common-color-02">
            <li>半角英数字8文字以上で登録してください。</li>
            <li>次回ログイン時に利用しますので大切に保管してください。</li></ul>
        </div>
        <p class="mail_mag-checkbox active"><input name="mail_mag" id="receive-btn" type="checkbox" value="1" checked/><label for="receive-btn">最新情報を受け取る</label></p>
        {/if}

        <input type="hidden" name="sns" value="none" />
        <input type="hidden" name="query_string" value="{$query_string}">
        {foreach from=$query_string_array item=value key=key}
        <input type="hidden" name="{$key}" value="{$value}">
        {/foreach}
        <div class="l-row__item--stretch">
          <button type="submit" class="submit common-bg-01" onclick="ga('send', 'event', 'cv2', 'click', '{$name|default:"不明"|escape}/メールアドレス', true);document.forms[0].elements['email_e'].value=encodeURIComponent(document.forms[0].elements['email'].value);">
        {if $notSend != 1}
            <div class="submit-btn">確認メール送信</div>
        {/if}
          </button>
        </div>
      </form>
    </div>

    <div class="subheading">
      <span>ソーシャルアカウントで会員登録</span>
    </div>

    <div class="l-row socialButtonGroup">

      <div class="g-signin" id="signinButton" data-callback="signinCallback" data-clientid="{$googleplusClientId}" data-cookiepolicy="{$g_cookiepolicy}" data-requestvisibleactions="http://schemas.google.com/AddActivity" data-scope="email" onclick="ga('send', 'event', 'cv2', 'click', '{$name|default:"不明"|escape}/google', true);">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11287" alt="Googleでログイン" width="36" height="36"></div>
      </div>

      <div class="sns-signin" scope="email" onclick="authenticateWithFacebook();">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11286" alt="Facebookでログイン" width="36" height="36"></div>
      </div>

      <div class="sns-signin" onclick="authenticateWithTwitter();">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11294" alt="Twitterでログイン" width="36" height="36"></div>
      </div>

      <a class="sns-signin" href="https://auth.login.yahoo.co.jp/yconnect/v1/authorization?response_type=code&redirect_uri={$yahooRegisterUrl}&client_id={$yahooAppId}&scope=openid+email&bail=1" onclick="ga('send', 'event', 'cv2', 'click', '{$name|default:"不明"|escape}/yahoo', true);">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11295" alt="Yahoo!JAPAN IDでログイン" width="36" height="36"></div>
      </a>

    </div>
  </div>
</section>

<div class="m-alert">
  <div class="l-content">
    <h6>すでにアカウントをお持ちのかたはこちら</h6>
    <a href="/authentication/login?{$login_query_string}" class="a-button a-button--default a-button--block">ログイン</a>
  </div>
</div>
<!--END: NEW TEMPLATE-->
{if $serviceCode == '0829_1001' || $serviceCode == '0000_0829_1001'}
<!--cocoloni_1-33-->

<section class="l-section">
  <div class="l-content">

    <!--
     <img src="http://websmart.ajapa.jp/web_image?url=http%3A%2F%2Fwebpayment.smart-stg%2Fimage%3Fid%3D10401" alt="すべてのサービスをお楽しみいただくには会員登録が必要です。" class="u-block">
   -->

    <h4>ひと月500円<small>(税抜)</small>で占い放題。</h4>
    <p class="a-caption">有料会員登録をするとこんなメリットがあります。</p>
    <div class="tmp-guestFeartureList">
      <div class="tmp-guestFeartureList__item">
        <div class="l-row--vMiddle">
          <span class="l-row__item tmp-guestFeartureList__count">1</span>
          <div class="l-row__item--stretch tmp-guestFeartureList__title">毎月新しい占いが追加されます。</div>
        </div>
        <span class="tmp-guestFeartureList__caption">
          「男子のトリセツ by 阿雅佐」の占いはこのサイト限定のものばかり。追加された占いを好きなだけお楽しみいただけます。
        </span>
      </div>

      <div class="tmp-guestFeartureList__item">
        <div class="l-row--vMiddle">
          <span class="l-row__item tmp-guestFeartureList__count">2</span>
          <div class="l-row__item--stretch tmp-guestFeartureList__title">絞り込み検索で気になる占いをすぐに見つけられます。</div>
        </div>
        <span class="tmp-guestFeartureList__caption">
          占いにはそれぞれ「結婚」「あの人の気持ち」などのカテゴリが登録されていて、手軽にカテゴリ別で占いたいことを見つけられます。
        </span>
      </div>

      <div class="tmp-guestFeartureList__item">
        <div class="l-row--vMiddle">
          <span class="l-row__item tmp-guestFeartureList__count">3</span>
          <div class="l-row__item--stretch tmp-guestFeartureList__title">パーソナル情報の登録で常にワンタップで占いができます。</div>
        </div>
        <span class="tmp-guestFeartureList__caption">
          生年月日や姓名などをご登録していただくと、その情報にもとづく緻密な診断を行う事ができます。
        </span>
      </div>
    </div>

    <hr>

    <h4>Fortune navigator 阿雅佐監修。</h4>
    <div class="m-media">
      <div>
        <div class="m-media__image">
          <img class="a-image--circle" width="80" height="80" src="https://websmart.zappallas.com/web_image?url=http%3A%2F%2Fwebpayment.smart-srv%2Fimage%3Fid%3D11338" alt="">
        </div>
        <div class="m-media__title">監修者：<ruby>阿雅佐<rt>あがさ</rt></ruby></div>
      </div>
        <div class="m-media__content">
          <div class="m-media__caption">
            <p>交友関係は多岐に渡り、有名人の“駆け込み寺”としても知られる。多数の著書をはじめ、年間100本以上の雑誌記事・Webコンテンツを執筆する恋占いのエキスパート。幅広いメディアで活躍中。</p>
            <p>古今東西の占いと心理学を駆使し、迷える子羊たちをナビするフォーチュン・ナビゲーター。会った人が皆幸せになるという評判から、幸運配達人の異名を取る。</p>
            <p>交友関係は多岐に渡り、有名人の“駆け込み寺”としても知られる。</p>
            <p>音大出身の血がいまだに騒ぎ、開運ライブと称するジャズライブを開催。α波を奏でる歌声を生で聴けば開運必至。</p>
            <p>多数の著書をはじめ、「ピチレモン」・「PASH!」など約10誌の連載誌、「anan」・「duet」ほか年間100本以上の雑誌記事・Webコンテンツを執筆する恋占いのエキスパート。テレビ・ラジオなど幅広いメディアで活躍中。今までに鑑定した人数はのべ1万人に及ぶ。</p>
          </div>
        </div>
    </div>
    <hr>
    <h5>ご利用可能な決済方法</h5>
    <div class="u-text-center">
      <img width="167" height="30" src="https://websmart.zappallas.com/web_image?url=http%3A%2F%2Fwebpayment.smart-srv%2Fimage%3Fid%3D11341"><br>
      <img width="168" height="30" src="https://websmart.zappallas.com/web_image?url=http%3A%2F%2Fwebpayment.smart-srv%2Fimage%3Fid%3D11340">
    </div>

  </div>
</section>
<section class="l-section">
<div class="l-content">
<div class="subheading">
  <span>メールアドレスで会員登録</span>
</div>

<div class="accordion-btn accordion-off">
  <div class="socialButton__image"><i class="material-icons" style="color: #AAA;line-height:44px;">&#xE0BE;</i></div>
  <span>メールアドレス・パスワード入力</span>
</div>

<div class="accordion-area" style="display: none;">
  <form id="js-generalForm" action="/authentication/mail_check" method="post">
    {if $notSend != 1}
    <div>
      <span>メールアドレスはログインIDとして利用します。</span>
      <input id="email" type="email" value="{$email}" name="email" class="a-input inputtext" />
      <input id="email_e" type="hidden" name="email_e" value="" />
      <div id="error-email"></div>
      {if $error_message }<span class="text error">{$error_message}</span>{/if}</div>

    <div>
      <span>登録するパスワードを入力してください</span>
      <div id="pass-area">
        <input type="password" id="password2" name="password" class="a-input" required>
        <input id="show-pass2" type="checkbox" /><label for="show-pass2" class="common-bg-02">パスワードを<br>表示</label></div>
      <div id="error-password"></div>
        {if $error_message }<span class="text error">{$error_message}</span>{/if}

      <ul class="a-caption common-color-02">
        <li>半角英数字8文字以上で登録してください。</li>
        <li>次回ログイン時に利用しますので大切に保管してください。</li></ul>
    </div>
    <p class="mail_mag-checkbox active"><input name="mail_mag" id="receive-btn" type="checkbox" value="1" checked/><label for="receive-btn">最新情報を受け取る</label></p>
    {/if}

    <input type="hidden" name="sns" value="none" />
    <input type="hidden" name="query_string" value="{$query_string}">
    {foreach from=$query_string_array item=value key=key}
    <input type="hidden" name="{$key}" value="{$value}">
    {/foreach}
    <div class="l-row__item--stretch">
          <button type="submit" class="submit common-bg-01" onclick="ga('send', 'event', 'cv2', 'click', '{$name|default:"不明"|escape}/メールアドレス', true);document.forms[1].elements['email_e'].value=encodeURIComponent(document.forms[1].elements['email'].value);">
    {if $notSend != 1}
        <div class="submit-btn">確認メール送信</div>
    {/if}
      </button>
    </div>
  </form>
</div>
<div class="subheading">
  <span>ソーシャルアカウントで会員登録</span>
</div>

<div class="l-row socialButtonGroup">

  <div class="g-signin" id="signinButton" data-callback="signinCallback" data-clientid="{$googleplusClientId}" data-cookiepolicy="{$g_cookiepolicy}" data-requestvisibleactions="http://schemas.google.com/AddActivity" data-scope="email" onclick="ga('send', 'event', 'cv2', 'click', '{$name|default:"不明"|escape}/google', true);">
    <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11287" alt="Googleでログイン" width="36" height="36"></div>
  </div>

  <div class="sns-signin" scope="email" onclick="authenticateWithFacebook();">
    <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11286" alt="Facebookでログイン" width="36" height="36"></div>
  </div>

  <div class="sns-signin" onclick="authenticateWithTwitter();">
    <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11294" alt="Twitterでログイン" width="36" height="36"></div>
  </div>

  <a class="sns-signin" href="https://auth.login.yahoo.co.jp/yconnect/v1/authorization?response_type=code&redirect_uri={$yahooRegisterUrl}&client_id={$yahooAppId}&scope=openid+email&bail=1" onclick="ga('send', 'event', 'cv2', 'click', '{$name|default:"不明"|escape}/yahoo', true);">
    <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11295" alt="Yahoo!JAPAN IDでログイン" width="36" height="36"></div>
  </a>

</div>
</div>
</div>
</section>
<div class="m-alert">
  <div class="l-content">
    <h6>すでにアカウントをお持ちのかたはこちら</h6>
    <a href="/authentication/login?{$login_query_string}" class="a-button a-button--default a-button--block">ログイン</a>
  </div>
</div>
<!--cocoloni_1-33_END-->
{/if}
<script type="application/json" id="json-data">
  {literal}
  {
  {/literal}
    "name": "{$name}",
    "facebookAppId": "{$facebookAppId}",
    "facebookAppVersion": "{$facebookAppVersion}"
  {literal}
  }
  {/literal}
</script>
<script>
  {literal}
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
    ga('send', 'event', 'cv2', 'click', data.name + '\/twitter', true);
    location.href = '/web_u_pay/authentication/twitter_register';
  }

  function authenticateWithFacebook() {
    // GoogleAnalytics event関数追加
    ga('send', 'event', 'cv2', 'click', data.name + '\/facebook', true);

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
          var redirectUrl = '/web_u_pay/authentication/mail_check' + location.search + (location.search ? '&' : '?') + 'email=' + response2.email + '&sns=facebook' + '&facebook_id=' + response2.id;
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
          var redirectUrl = '/web_u_pay/authentication/mail_check' + location.search + (location.search ? '&' : '?') + 'email=' + profile.emails[0].value + '&google_id=' + profile.id + '&sns=google';
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
  {/literal}
</script>
{include file='../include/_PLUS_footer.tpl'}
{* END :  新FW新認証テンプレート *}

{/if}
