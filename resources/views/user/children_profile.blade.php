@extends('layout.app.master')
@section('content')


{{-- 完了画面 --}}
@if (@$btn_complete)

プロフィール登録完了<br>
<br>
<a href="/user/mypage">戻る</a><br>



{{-- 確認画面 --}}
@elseif (@$btn_check)

<h1 class="title-second__main">子どものプロフィール追加・確認・変更</h1>

<form action="/user/children_profile" method="post">

<div class="form-main">
<form action="/user/children_profile" method="post">
  {{ csrf_field() }}
  <h2 class="title-second__sub">子供の情報</h2>
  <dl class="form-checkList">
    <dt>ニックネーム</dt>
    <dd>{{@$nickname}}</dd>
    <dt>姓名（漢字）</dt>
    <dd>{{@$last_name}} {{@$first_name}}</dd>
    <dt>姓名（かな）</dt>
    <dd>{{@$last_name_kana}} {{@$first_name_kana}}</dd>
    <dt>生年月日</dt>
    <dd>{{@$birthday_y}}年 {{@$birthday_m}}月 {{@$birthday_d}}日</dd>
    <dt><?php $birthorder_st = [1 => 'いちばん上', 2 => '真ん中', 3 => '末っ子', 4 => 'ひとりっ子']; ?>生まれ順</dt>
    <dd>{{$birthorder_st[@$birthorder]}}</dd>
    <dt>出生時間</dt>
    <dd>{{(@$birthtime_unknown) ? '不明' : @$birthtime}}</dd>
    <dt><?php $blood_st = [0 => '不明', 1 => 'A', 2 => 'B', 3 => 'O', 4 => 'AB']; ?>血液型:</dt>
    <dd>{{$blood_st[@$blood]}}</dd>
    <dt><?php $gender_st = ['f' => '女性', 'm' => '男性']; ?>性別:</dt>
    <dd>{{$gender_st[@$gender]}}</dd>
    <dt>出生地:</dt>
    <dd>{{@$prfile_area[@$from_pref]}}</dd>
  </dl>

    <input type="hidden" name="cid" value="{{@$cid}}">
    <input type="hidden" name="nickname" value="{{@$nickname}}">
    <input type="hidden" name="last_name" value="{{@$last_name}}">
    <input type="hidden" name="first_name" value="{{@$first_name}}">
    <input type="hidden" name="last_name_kana" value="{{@$last_name_kana}}">
    <input type="hidden" name="first_name_kana" value="{{@$first_name_kana}}">
    <input type="hidden" name="birthday_y" value="{{@$birthday_y}}">
    <input type="hidden" name="birthday_m" value="{{@$birthday_m}}">
    <input type="hidden" name="birthday_d" value="{{@$birthday_d}}">
    <input type="hidden" name="birthday" value="{{@$birthday}}">
    <input type="hidden" name="birthtime" value="{{@$birthtime}}">
    <input type="hidden" name="birthtime_unknown" value="{{@$birthtime_unknown}}">
    <input type="hidden" name="blood" value="{{@$blood}}">
    <input type="hidden" name="gender" value="{{@$gender}}">
    <input type="hidden" name="from_pref" value="{{@$from_pref}}">
    <input type="hidden" name="birthorder" value="{{@$birthorder}}">

  {{-- ボタンnameで遷移先を制御しているので変更しないこと --}}
  <div class="button-profile">
      <input type="submit" name="btn_check" value="登録する" />
    </div>
  </form>
  <form action="/user/mypage" method="post">
    {{ csrf_field() }}
    <div class="page-back">
      <input type="submit" name="btn_return" value="戻る"/>
    </div>
  </form>

</div>

</form>


{{-- 入力画面 --}}
@else

{{-- DBから取得した $icon_imgfile を画像名に付与して画像パス指定 --}}
<a href="/user/children_image?cid={{@$cid}}"><img src="#{{@$icon_imgfile}}"><br>
アイコンを編集<br></a>



<form action="/user/children_profile" method="post">
  {{ csrf_field() }}
  <input type="hidden" name="cid" value="{{@$cid}}">

  ニックネーム<br>
  <input type="text" name="nickname" value="{{@$nickname}}">
  <br>
  <br>
  姓名（漢字）<br>
  <input type="text" name="last_name" value="{{@$last_name}}">
  <input type="text" name="first_name" value="{{@$first_name}}">
  <br>
  <br>
  姓名（かな）<br>
  <input type="text" name="last_name_kana" value="{{@$last_name_kana}}">
  <input type="text" name="first_name_kana" value="{{@$first_name_kana}}">
  <br>
  <br>
  生年月日<br>
  <input type="text" name="birthday_y" value="{{@$birthday_y}}">年
  <input type="text" name="birthday_m" value="{{@$birthday_m}}">月
  <input type="text" name="birthday_d" value="{{@$birthday_d}}">日
  <br>
  <br>
  出生時間<br>
  <input type="text" name="birthtime" value="{{@$birthtime}}">
  <br>
  <br>
  出生時間不明<br>
  <input type="checkbox" name="birthtime_unknown" value="1" @if(@$birthtime_unknown) checked @endif>
  <br>
  <br>
  血液型:
  <select name="blood">
    <option value="0" @if(!@$blood) selected @endif>不明</option>
    <option value="1" @if(@$blood == 1) selected @endif>A</option>
    <option value="2" @if(@$blood == 2) selected @endif>B</option>
    <option value="3" @if(@$blood == 3) selected @endif>O</option>
    <option value="4" @if(@$blood == 4) selected @endif>AB</option>
  </select>
&nbsp;
  性別:
  <select name="gender">
    <option value="f" @if(@$gender == 'f') selected @endif>女性</option>
    <option value="m" @if(@$gender == 'm') selected @endif>男性</option>
  </select>
&nbsp;
  出生地:{{-- iriya.pga.jpを参考 --}}
  <select name="from_pref">
    @foreach (@$prfile_area as $key => $value)
    <option value="{{@$key}}" @if(@$key == @$from_pref) selected @endif>{{@$value}}</option>
    @endforeach
  </select>
<br>
<br>

  生まれ順<br>{{-- abo.pga.jpを参考 --}}
  <select name="birthorder">
    <option value="1" @if(@$birthorder == 1) selected @endif>いちばん上</option>
    <option value="2" @if(@$birthorder == 2) selected @endif>真ん中</option>
    <option value="3" @if(@$birthorder == 3) selected @endif>末っ子</option>
    <option value="4" @if(@$birthorder == 4) selected @endif>ひとりっ子</option>
  </select>
<br>
<br>

  {{-- ボタンnameで遷移先を制御しているので変更しないこと --}}
  <input type="submit" name="btn_check" value="確認する" /><br>
</form>
<form action="/user/mypage" method="post">
  {{ csrf_field() }}
  <input type="submit" name="btn_return" value="戻る" />
</form>


@endif




@endsection