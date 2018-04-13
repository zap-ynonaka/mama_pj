{if $newAuth}<!-- 旧FW新認証 -->
  {include file='../include/header_new_auth.tpl'}
  {include file='../include/common.tpl'}

  <ol class="stepBar step4">
    <li class="step"><img src="/img/step01.png" alt="認証方法選択" /></li>
    <li class="step current"><img src="/img/step02.png" alt="メール送信" /></li>
    <li class="step"><img src="/img/step03.png" alt="メール送信完了" /></li>
    <li class="step"><img src="/img/step04.png" alt="パスワード設定" /></li>
  </ol>

  <div class="btnBlock">
    <form method="post">
      <p class="text textCenter">
        {if $notSend != 1}
        以下のアドレスに確認メールを送信します。<br />
        <p class="mb10">メールアドレス：<input type="email" value="{$email}" name="email" class="inputtext" {if $email}readonly{/if}/></p>
        {/if}
      </p>
      <input type="hidden" name="sns" value="{$sns}">
      <input type="hidden" name="twitter_id" value="{$twitter_id}">
      <input type="hidden" name="facebook_id" value="{$facebook_id}">
      <input type="hidden" name="google_id" value="{$google_id}">
      <input type="hidden" name="yahoo_id" value="{$yahoo_id}">
      <input type="hidden" name="query_string" value="{$query_string}">
      {if $error_message }<p class="text error">{$error_message}</p>{/if}
      {if $notSend != 1}
      <p><input type="submit" class="btn" value="確認メール送信" /></p>
      {/if}
    </form>
  </div>

  <div class="btnBlock">
    <a href="/authentication/login?{$login_query_string}" class="btn">ログインはこちら</a>
  </div>

  {include file='../include/footer_new_auth.tpl'}

{else}

  {* START :  新FW新認証テンプレート *}
  {include file='../include/_PLUS_header.tpl'}
  {include file='../include/common.tpl'}

  <script>
    {literal}
    $(function() {

    $('#show-pass').on('click', function() {
      if ($('#password').get(0).type === 'password'){
        $('#password').get(0).type = 'text';
        $('#pass-area label').removeClass('common-bg-01');
      } else {
        $('#password').get(0).type = 'password';
        $('#pass-area label').addClass('common-bg-01');
      }
    });



      $('#email').on('blur',function(){
        if ($('#email').hasClass('valid')) {
          $('#error-email').addClass('check');
        } else {
          $('#error-email').removeClass('check');
        }
      });

      $('#password').on('blur',function(){
        if ($('#password').hasClass('valid')) {
          $('#error-password').addClass('check');
        } else {
          $('#error-password').removeClass('check');
        }
      });

      $('button.submit').on('click', function() {
        $('#password').get(0).type = 'password';
      });


      $('#receive-btn').on('click', function() {
        $('.mail_mag-checkbox').toggleClass('active');
      });

    });

    {/literal}
  </script>

  <section class="l-section">
    <div class="l-content">
      <h3>会員登録</h3>
      <div class="stepbar">
        <img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11311">
      </div>

      <h5 class="u-text-left">月額{$price}円(税込)</h5>
      <h6 class="common-color-01">{$name}</h6>
      <p class="a-caption"><a class="common-color-02" href="{$content_url}/help/terms">利用規約</a>および<a class="common-color-02" href="http://www.zappallas.com/etc/?WEBSMARTOUT=1">プライバシーポリシー</a>に同意のうえ会員登録の方法をお選びください。</p>

      {if $sns === 'yahoo'}
      <div class="socialButton-area accordion-btn">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11295" alt="Yahoo!JAPAN IDでログイン" width="36" height="36"></div>
        <div>yahoo!IDと連携</div></div>
      {elseif $sns === 'google'}
      <div class="socialButton-area accordion-btn">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11287" alt="Googleでログイン" width="36" height="36"></div>
        <div>googleと連携</div></div>
      {elseif $sns === 'facebook'}
      <div class="socialButton-area accordion-btn">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11286" alt="Facebookでログイン" width="36" height="36"></div>
        <div>facebookと連携</div></div>
      {elseif $sns === 'twitter'}
      <div class="socialButton-area accordion-btn">
        <div class="socialButton__image"><img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart%2dsrv%2fimage%3fid%3d11294" alt="Twitterでログイン" width="36" height="36"></div>
        <div>twitterと連携</div></div>
      {/if}

      <div class="mail-check-area">
        {include file='../include/error_message.tpl'}
        <form method="post" class="o-formGroup" id="js-mailCheckForm">
          <input type="hidden" name="sns" value="{$sns}">
          <input type="hidden" name="twitter_id" value="{$twitter_id}">
          <input type="hidden" name="facebook_id" value="{$facebook_id}">
          <input type="hidden" name="google_id" value="{$google_id}">
          <input type="hidden" name="yahoo_id" value="{$yahoo_id}">
          <input type="hidden" name="query_string" value="{$query_string}">
          <span>メールアドレスはログインIDとして利用します。</span>
          <div class="m-formControl">
            <div class="m-formControl__field">
             {if $notSend != 1}
              <input type="email" id="email" name="email" class="a-input" placeholder="メールアドレスを入力" value="{$email}" required>
              <input id="email_e" type="hidden" name="email_e" value="" />
             {/if}
             <div id="error-email"></div>
              {if $error_message }<label for="email" class="error-message error">{$error_message}</label>{/if}
            </div>
          </div>
          <span>登録するパスワードを入力してください</span>
          <div id="pass-area">
            <input type="password" id="password" name="password" class="a-input" required>
            <input id="show-pass" type="checkbox" /><label for="show-pass" class="common-bg-01">パスワードを表示</label></div>
            <div id="error-password"></div>
            {if $error_message }<span class="text error">{$error_message}</span>{/if}

          <ul class="a-caption common-color-02">
            <li>半角英数字8文字以上で登録してください。</li>
            <li>次回ログイン時に利用しますので大切に保管してください。</li></ul>
          <p class="mail_mag-checkbox active"><input name="mail_mag" id="receive-btn" type="checkbox" value="1" checked/><label for="receive-btn">最新情報を受け取る</label></p>
          {if $notSend != 1}
          <button type="submit" class="a-button a-button--block a-button--accent submit common-bg-01" onclick="ga('send', 'event', 'cv2', 'click', '{$name|default:"不明"|escape}/メールアドレス', true);document.getElementById('email_e').value=encodeURIComponent(document.getElementById('email').value);">
            <div class="submit-btn">確認メール送信</div>
          </button>
          {/if}
        </form>
        <div class="m-alert" style="display: none;">
          <div class="l-content">
            <h6>メールアドレス及びSNSアカウント登録時のご注意</h6>
            <ul class="a-caption" style="margin-bottom: 0;">
              <li>メールアドレス・SNSアカウントでご登録される場合、お支払いはクレジットカード（Visa/Master、JCB/AMEX）、もしくは対象のクレジットカードをお持ちでない方は携帯電話料金支払い(docomo/au/ソフトバンク)でのご登録をお願いいたします。</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <ul class="o-listGroup">
      <li class="m-listItem o-listGroup__item"><a href="{$content_url}">
        <div class="m-listItem__content">
          <h4 class="m-listItem__title">{$name}トップ</h4>
        </div>
        <i class="m-listItem__arrow material-icons">&#xE5CC;</i>
      </a></li>
      <li class="m-listItem o-listGroup__item"><a href="/authentication/login?{$login_query_string}">
        <div class="m-listItem__content">
          <h4 class="m-listItem__title">ログイン</h4>
        </div>
        <i class="m-listItem__arrow material-icons">&#xE5CC;</i>
      </a></li>
    </ul>
  </section>
  <script>
  var name = '{$name}';
  {literal}
  $(function() {
    var $mailCheckForm = $('#js-mailCheckForm');
    var rules = {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        harfsize: true,
        minlength: 8,
      }
    };

    var messages = {
      email: {
        required: 'この項目は入力必須です。',
        email: 'メールアドレスの形式が正しくありません。',
      },
      password: {
        required: 'この項目は入力必須です。',
        harfsize: 'パスワードは半角英数8文字以上で入力してください。',
        minlength: 'パスワードは半角英数8文字以上で入力してください。',
      }
    };

    var submitHandler = function(form) {
      // formがvalidである時のみgaイベントを送信する
      ga('send', 'event', 'cv3', 'click', name + '\/確認メールの送信', true);
      form.submit();
    }

    $mailCheckForm.validate({
      rules: rules,
      messages: messages,
      submitHandler: submitHandler,
      errorPlacement: function(error,element){
        $('#error-' + element.attr('name')).append(error);
        console.log(error,element);
      },
      onkeyup: false
    });
  });
  {/literal}
  </script>
  {include file='../include/_PLUS_footer.tpl'}
{* END :  新FW新認証テンプレート *}
{/if}
