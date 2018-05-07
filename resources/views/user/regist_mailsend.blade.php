@extends('layout.app.master')
@section('content')


<section class="second-space2">
  <div class="register-confirm content-space__second">
      <h2 class="title-sub outerside">メール送信完了</h2>
      <ul class="form-register__navi">
        <li><img src="/images/regist/step-1-off.png" alt=""></li>
        <li><img src="/images/regist/step-2-on.png" alt=""></li>
        <li><img src="/images/regist/step-3-off.png" alt=""></li>
      </ul>

    @include('layout.error_message')

    <p>{{$email ?? ''}}に確認用のURLを送信しました。届いたメールを開き<b class="register-confirmFont">URLをクリック</b>し、登録へとお進みください。</p>

      <ul class="register-confirmReturn">
        <h3 class="register-confirmTitle">メールが届かない場合</h3>
        <li>
          再度入力をお試しください

        <div class="button-default">
            @if( $sns ?? ''  == 'none' OR $sns ?? '' == '')
          <a class="button" href="/user/regist_input?{{$register_query_string ?? ''}}">
            @else
          <a class="button" href="/user/regist_mail_check?{{$register_query_string ?? ''}}">
            @endif
        入力画面に戻る</a></div>
        </li>
        <li>迷惑メールフォルダに届いていないかお確かめください。</li>
        <li>「<span class="register-confirmFont">zappallas.com</span>」ドメインからのメールを受信できるように設定してください。</li>
        <li>解決しない場合は<a class="register-confirmFont" href="{{$content_url ?? ''}}/inquiry">お問い合わせ</a>よりご連絡ください。</li>
      </ul>

    <!-- <div class="button-default">
      <a href="/user/mypage" class="">マイページに戻る</a>
    </div> -->
</div>
</section>

@endsection







<!-- <div style="display:none;">
<script>
  $(function() {
    $('.accordion-btn').on('click',function () {
      $('.accordion-btn + .accordion-area').slideToggle();
      $(this).toggleClass('accordion-off');
    });
  });
</script>
<section class="l-section">
  <div class="l-content resending-mail-area">
    <h3>会員登録</h3>
    <div class="stepbar">
      <img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart-srv%2fimage%3fid%3d11311%22%3E">
    </div>
    <h3>確認メール送信完了</h3>

    @include('layout.error_message')

    <p class="a-caption">ご入力頂いたメールアドレス</p>
    <p class="u-text-center common-color-01">{{$email ?? ''}}</p>
    <p class="a-caption">に確認用のURLを送信しました。届いたメールを開き、記載された<b class="common-color-02">確認用URLをクリックし</b>、決済ページへとお進みください。</p>

    <div class="accordion-btn accordion-off">
      <img src="https://websmart.zappallas.com/web_image?url=http%3a%2f%2fwebpayment%2esmart-srv%2fimage%3fid%3d11309%22%3E">
      <span>メールが届かない場合</span>
    </div>

    <div class="accordion-area" style="display: none;">
      <ul class="a-caption" style="margin-bottom: 0;">
        <li>
          再度入力をお試しください
            @if( $sns ?? ''  == 'none' OR $sns ?? '' == '')
          <a class="button" href="/user/regist_input?{{$register_query_string ?? ''}}">
            @else
          <a class="button" href="/user/regist_mail_check?{{$register_query_string ?? ''}}">
            @endif
            <button class="a-button a-button--block a-button--default">入力画面に戻る</button>
          </a>
        </li>
        <li>迷惑メールフォルダにメールが届く可能性がございますので届かない場合は迷惑メールフォルダをご確認ください。</li>
        <li>「<span>zappallas.com</span>」ドメインからのメールを、受信可能に設定頂きますようお願い致します。（@を含めずにご登録下さい）</li>
        <li>URL付きのメール・パソコンからのメールを拒否されている場合は、メールが届かない場合がございますので、併せてご確認下さい。</li>
        <li>解決しない場合は<a class="caution" href="{{$content_url ?? ''}}/inquiry">お問い合わせ</a>よりご連絡ください。</li>
      </ul>
    </div>
  </div>
</section>

</div> -->