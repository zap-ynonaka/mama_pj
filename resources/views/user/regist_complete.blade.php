@extends('layout.app.master')
@section('content')

  <div class="l-content card-complate u-text-center">
  <h3>{{$email ?? ''}}</h3>
  <br>
  <span class="common-color-01">メールアドレス、パスワードの登録が完了しました</span><br>
  <br>
    さっそく占う！<br>
    <a href="/user/my_profile"><span>プロフィール登録へ&nbsp;></span></a>
  </div>

@endsection