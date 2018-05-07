@extends('layout.app.master')
@section('content')

<h1 class="title-second__main">あなたのプロフィール確認・変更</h1>

{{-- 完了画面 --}}
@if (@$btn_complete)

<div class="form-complate">
@if (@$action == 'delete')
  <div class="form-complate__message">登録されているプロフィールを削除しました。</div>
@else
  <div class="form-complate__message">プロフィールを更新しました。</div>
@endif

  <div class="form-submit__back">
    <a href="/user/mypage">マイページに戻る</a>
  </div>


</div>

{{-- 確認画面 --}}
@elseif (@$btn_check)


<div class="form-main">
  <h2 class="title-second__sub">あなたの情報</h2>
  <div class="mypage-form">
    <form action="/user/my_profile" method="post">
      <input type="hidden" name="callbackurl" value="{{@$callbackurl}}">
      {{ csrf_field() }}

      <dl class="form-checkList">
        <dt>ニックネーム</dt>
        <dd>{{@$nickname}}</dd>
        <dt><?php $gender_st = ['f' => '女性', 'm' => '男性']; ?>性別:</dt>
        <dd>{{@$gender_st[@$gender]}}</dd>
        <dt>生年月日</dt>
        <dd>{{@$birthday_y}}年 {{@$birthday_m}}月 {{@$birthday_d}}日</dd>
        <dt>出生時間</dt>
        <dd>{{(@$birthtime_unknown) ? '不明' : @$birthtime}}</dd>
        <dt>出生地:</dt>
        <dd>{{@$prfile_area[@$from_pref]}}</dd>
      </dl>


      <input type="hidden" name="nickname" value="{{@$nickname}}">
      <input type="hidden" name="gender" value="{{@$gender}}">
      <input type="hidden" name="birthday_y" value="{{@$birthday_y}}">
      <input type="hidden" name="birthday_m" value="{{@$birthday_m}}">
      <input type="hidden" name="birthday_d" value="{{@$birthday_d}}">
      <input type="hidden" name="birthday" value="{{@$birthday}}">
      <input type="hidden" name="birthtime" value="{{@$birthtime}}">
      <input type="hidden" name="from_pref" value="{{@$from_pref}}">
      <!-- <input type="hidden" name="last_name" value="{{@$last_name}}">
      <input type="hidden" name="first_name" value="{{@$first_name}}">
      <input type="hidden" name="maiden_name" value="{{@$maiden_name}}">
      <input type="hidden" name="last_name_kana" value="{{@$last_name_kana}}">
      <input type="hidden" name="first_name_kana" value="{{@$first_name_kana}}">
      <input type="hidden" name="birthtime_unknown" value="{{@$birthtime_unknown}}">
      <input type="hidden" name="blood" value="{{@$blood}}">
      <input type="hidden" name="birthorder" value="{{@$birthorder}}"> -->

      @include('form.formSubmit')

    </form>
  </div>
</div>

<div class="page-back">
  <a href="/user/mypage">戻る</a>
</div>


{{-- 入力画面 --}}
@else

<div class="form-main">
<div class="form-check__massage">まだプロフィールが登録されていません。</div>
  <h2 class="title-second__sub">あなたの情報</h2>
  <div class="mypage-form">

    <form action="/user/my_profile" method="post">
      <input type="hidden" name="callbackurl" value="{{@$callbackurl}}">
    <?php $params = ['nickname', 'gender', 'birth', 'birthTime', 'birthPlace']; ?>
    @include('form.formBase')

    @include('form.formCheck')

    </form>

    <form action="/user/my_profile" method="post">
      @include('form.formDelete')
    </form>
  </div>
</div>
</div>

<div class="page-back">
  <a href="/user/mypage">戻る</a>
</div>

<script>
$(function(){

var formNumber = '';

gender( formNumber );
blood( formNumber );
birthOrder( formNumber );
birthDay( formNumber );
birthTime( formNumber );
pref( formNumber );
childImg( formNumber );

});
</script>

@endif




@endsection