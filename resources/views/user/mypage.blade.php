@extends('layout.app.master')
@section('content')

<?php $gender_st = ['f' => '女性', 'm' => '男性']; ?>
<?php $blood_st = [0 => '不明', 1 => 'A', 2 => 'B', 3 => 'O', 4 => 'AB']; ?>

<h1>マイページ</h1>
<section>
  <h2>プロフィール設定</h2>
  <div class="content-space__top">
    <ul>
      <li><a href="/user/partner_profile">あなたのプロフィール確認・変更</a></li>
      <li><a href="/user/partner_profile">相手のプロフィール確認・変更</a></li>
      <li><a href="/user/children">子どもの情報を追加する</a></li>
    </ul>
  </div>

  <h2>登録情報</h2>
  <div class="content-space__top">
    <ul>
      <li><a href="/user/favorite_list">お気に入りの占い結果</a></li>
      <li><a href="/user/change_email">メールアドレス変更</a></li>
      <li><a href="/user/change_password">パスワード変更</a></li>
    </ul>
  </div>

  <h2>その他</h2>
  <div class="content-space__top">
    <ul>
      <li><a href="/user/partner_profile">ログアウト</a></li>
    </ul>
  </div>
</section>

あなたの情報<br>
@if(@$nickname)
  {{@$nickname}}さん &nbsp; {{@$gender_st[@$gender]}} &nbsp; {{@$age}}歳 &nbsp; 生年月日 {{date('Y/m/d',strtotime(@$birthday))}} &nbsp;{{(@$birthtime_unknown) ? '時間不明' : @$birthtime}}
  <br>
  血液型:{{@$blood_st[@$blood]}}型 &nbsp; ホロスコープ情報<br>
  <br>
@endif
<a href="/user/my_profile">プロフィール編集</a><br>
<br>

パートナーの情報<br>
@if(@$pt_nickname)
  {{@$pt_nickname}}さん &nbsp; {{@$gender_st[@$pt_gender]}} &nbsp; {{@$pt_age}}歳 &nbsp; 生年月日 {{date('Y/m/d',strtotime(@$pt_birthday))}} &nbsp;{{(@$pt_birthtime_unknown) ? '時間不明' : @$pt_birthtime}}
  <br>
血液型:{{@$blood_st[@$pt_blood]}}型 &nbsp; ホロスコープ情報<br>
  <br>
@endif
<a href="/user/partner_profile">プロフィール編集</a><br>
<br>

子供の情報<br>

@foreach (@$children as $c)

<a href="/user/children_profile?cid={{@$c->id}}"><img src="#{{@$c->icon_imgfile}}"></a> &nbsp;

{{-- 画像3つ毎に改行--}}
@if($loop->iteration % 3 == 0)<br>@endif

@endforeach
<br>
<a href="/user/children_profile">子どもの情報を追加する</a><br>
<br>
<br>

実母の情報<br>
@if(@$mym_nickname)
  {{@$mym_nickname}}さん &nbsp; {{@$gender_st[@$mym_gender]}} &nbsp; {{@$mym_age}}歳 &nbsp; 生年月日 {{date('Y/m/d',strtotime(@$mym_birthday))}} &nbsp;{{(@$mym_birthtime_unknown) ? '時間不明' : @$mym_birthtime}}
  <br>
  血液型:{{@$blood_st[@$mym_blood]}}型 &nbsp; ホロスコープ情報<br>
  <br>
@endif
<a href="/user/my_mother_profile">プロフィール編集</a><br>
<br>

義母の情報<br>
@if(@$mym_nickname)
  {{@$ptm_nickname}}さん &nbsp; {{@$gender_st[@$ptm_gender]}} &nbsp; {{@$ptm_age}}歳 &nbsp; 生年月日 {{date('Y/m/d',strtotime(@$ptm_birthday))}} &nbsp;{{(@$ptm_birthtime_unknown) ? '時間不明' : @$ptm_birthtime}}
  <br>
  血液型:{{@$blood_st[@$ptm_blood]}}型 &nbsp; ホロスコープ情報<br>
  <br>
@endif
<a href="/user/partner_mother_profile">プロフィール編集</a><br>
<br>
<br>
<br>
<a href="/user/favorite_list">お気に入り結果保存</a><br>
<br>
<a href="/user/change_email">メールアドレス変更</a><br>
<br>
<a href="/user/change_password">パスワード変更</a><br>
<br>

@endsection