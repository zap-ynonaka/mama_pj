@extends('layout.app.master')

@section('content')


<div class="contentBody">
  <div class="contentBody__section">
    <h1 class="pageTitle">パスワードの変更</h1>

    @if ( $error_message ?? '' )<br><span class="text error">{{$error_title ?? ''}}&nbsp;{{$error_message}}</span><br><br>@endif


    @if (($method_type ?? '') == 'post' ) {{-- POST時表示内容 --}}

    <p>パスワードを変更しました。</p>


    @else {{-- GET時表示内容 --}}

<br>
<form name="frm" action="/user/change_password" method="post">
    {{ csrf_field() }}
    現在のパスワード<br>
    <input type="text" name="password" value="" /><br>
    <br>
    新しいパスワード<br>
    <input type="text" name="new_password" value="" /><br>
    <br>
    新しいパスワード(確認)<br>
    <input type="text" name="re_new_password" value="" /><br>
    <br>
    <input type="submit" value="変更する">
</form>

    @endif

  </div>
</div>




@endsection


