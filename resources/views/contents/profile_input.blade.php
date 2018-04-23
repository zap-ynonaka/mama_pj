@extends('layout.app.master')
@section('content')

必要情報入力<br>
メニュー名:{{@$menu_name}}<br>
<br>
elem:{{$elem}}<br>
affinity:{{$affinity}}<br>


<?php $affi1 = ['自分','子供','パートナー','義母','実母','実母','一人目','','','','','自分','自分','自分','自分','実母','一人目']; ?>
{{$affi1[$affinity]}}情報入力<br>

<br>
<form action="/contents/profile_input/{{$menus_id}}" method="post">
  <input type="hidden" name="callbackurl" value="{{$callbackurl}}">

  @if($elem == 2)
    <?php $params = ['nickname', 'name']; ?>
    @include('form.formBase')
  @endif

  @if($elem == 1)
    <?php $params = ['nickname', 'birth', 'birthTime', 'birthPlace']; ?>
    @include('form.formBase')
  @endif

@if($elem == 2)
  名前（かな）<br>
  <input type="text" name="first_name_kana" value="{{@$first_name_kana}}">
  <br>
@endif

<!-- @if($elem == 1)
  生年月日<br>
  <input type="text" name="birthday_y" value="{{@$birthday}}">年
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
  出生地:{{-- iriya.pga.jpを参考 --}}
  <select name="from_pref">
    @foreach (@$prfile_area as $key => $value)
    <option value="{{@$key}}" @if(@$key == @$from_pref) selected @endif>{{@$value}}</option>
    @endforeach
  </select>
  <br>
  <br>
@endif -->


@if($affinity >= 10)
  <br>
  <br>
  <br>
<?php $affi2 = ['','','','','','','','','','','','子供','パートナー','義母','実母','義母','二人目']; ?>
{{$affi2[$affinity]}}情報入力<br>
  <br>
  ニックネーム<br>
  <input type="text" name="nickname2" value="{{@$nickname}}">
  <br>
  <br>
@if($elem == 2)
  名前（かな）<br>
  <input type="text" name="first_name_kana2" value="{{@$first_name_kana}}">
  <br>
@endif

@if($elem == 1)
  生年月日<br>
  <input type="text" name="birthday_y2" value="{{@$birthday_y2}}">年
  <input type="text" name="birthday_m2" value="{{@$birthday_m2}}">月
  <input type="text" name="birthday_d2" value="{{@$birthday_d2}}">日
  <br>
  <br>
  出生時間<br>
  <input type="text" name="birthtime2" value="{{@$birthtime2}}">
  <br>
  <br>
  出生時間不明<br>
  <input type="checkbox" name="birthtime_unknown2" value="1" @if(@$birthtime_unknown2) checked @endif>
  <br>
  <br>
  出生地:{{-- iriya.pga.jpを参考 --}}
  <select name="from_pref2">
    @foreach (@$prfile_area as $key => $value)
    <option value="{{@$key}}" @if(@$key == @$from_pref) selected @endif>{{@$value}}</option>
    @endforeach
  </select>
  <br>
  <br>
@endif

@endif

  {{-- ボタンnameで遷移先を制御しているので変更しないこと --}}
  <input type="submit" name="btn_check" value="占う" /><br>
</form>





@endsection