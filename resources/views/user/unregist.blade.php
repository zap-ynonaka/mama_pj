@extends('layout.app.master')
@section('content')


<section class="l-section">
  <div class="l-content">
    <h3>退会</h3>


  @if (($method_type ?? '') == 'post' ) {{-- POST時表示内容 --}}

    @include('layout.error_message')
    <p><b>『{{$name}}』</b>の退会処理が完了しました。ご利用ありがとうございました。</p>

  </div>
  <ul class="o-listGroup">
    <li class="m-listItem o-listGroup__item"><a href="/">
      <div class="m-listItem__content">
        <h4 class="m-listItem__title">{{$name ?? ''}}トップ</h4>
      </div>
      <i class="m-listItem__arrow material-icons">&#xE5CC;</i>
    </a></li>
  </ul>
</section>

  @else {{-- GET時表示内容 --}}

    @include('layout.error_message')

    <p><b>『{{$name ?? ''}}』</b>を退会しますか？</p>
    <div class="m-alert">
      <div class="l-content">
        <h6>退会のご注意</h6>
        <ul class="a-caption">
          <li>ご登録いただいたお客様のプロフィールなど、お客様のアカウントに関連するすべてのデータが消去されます。</li>
          <li>会員登録を解除されると当サービス内の会員登録が必要な全てメニューがご利用いただけなくなります。</li>
          <li>同月内であっても退会後に再度、月額決済を行った場合は重複して決済されますのでご了承ください。詳しくは<a href="/help/law/">特定商取引法に関する表示</a>をご参照ください。</li>
        </ul>
      </div>
    </div>
    <form action="/user/unregist" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action_detail" value="detach">
      <button type="submit" class="a-button a-button--default a-button--block">退会する</button>
      <a href="/" class="a-button a-button--default a-button--block">キャンセル</a>
    </form>
  </div>
</section>

  @endif







@endsection