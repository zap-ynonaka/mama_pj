@extends('layout.app.master')

@section('content')
<form-area method="post" action="{{ route('mypage.change_password_complete') }}" scope="newPassword">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
  <input type="hidden" name="reissue_key" value="{{$reissue_key ?? ''}}">

  <div class="contentBody">
    <div class="contentBody__section">
      <h1 class="pageTitle">パスワードの変更</h1>
      <form-password
        name="password"
        placeholder="新しいパスワード"
        :validation="{ rules: {
          required: true
        } }"
      ></form-password>
      <form-password
        name="re_password"
        placeholder="新しいパスワード(確認)"
        :validation="{ rules: {
          required: true
        } }"
        :strength-meter="false"
      ></form-password>
    </div>
  </div>
  <div class="contentFooter">
    <button type="submit" class="btn"
      data-color="white"
      data-block="true"
    >パスワードを変更する</button>
  </div>
</form-area>
@endsection


