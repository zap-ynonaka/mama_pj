@extends('layout.app.master')

@section('content')


<section class="second-space2">

    @if ( $error_message ?? '' )<br><span class="text error">{{$error_title ?? ''}}&nbsp;{{$error_message}}</span><br><br>@endif


  @if (($method_type ?? '') == 'post' ) {{-- POST時表示内容 --}}
  <div class="register-complete content-space__second">
    <h2 class="title-sub outerside">パスワード変更</h2>
    <p>パスワードを変更しました。</p>
  </div>

    @else {{-- GET時表示内容 --}}
  <div class="content-space__second">
    <h1 class="title-sub outerside">パスワード変更</h1>
      <div class="form-register">
        <form name="frm" action="/user/change_password" method="post">
            <div class="form-register__mailChange"></div>
            {{ csrf_field() }}
            <span>現在のパスワードを入力</span>
            <input type="text" name="password" class="form-register__input" value="" />
            <span>新しいパスワードを入力</span>
            <input type="text" name="new_password" class="form-register__input" value="" />
            <span>新しいパスワードを入力(確認)</span>
            <input type="text" name="re_new_password" class="form-register__input" value="" />
            <div class="button-default">
              <input type="submit" value="変更する">
            </div>
        </form>
      </div>
    <div class="page-back outerside"><a href="">戻る</a></div>
  </div>
    @endif


</section>




@endsection


