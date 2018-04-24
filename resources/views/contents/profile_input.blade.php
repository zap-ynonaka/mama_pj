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



@if($affinity >= 10)
  <?php $affi2 = ['','','','','','','','','','','','子供','パートナー','義母','実母','義母','二人目']; ?>
  {{$affi2[$affinity]}}情報入力<br>
  @if($elem == 2)
    <?php $params = ['nickname2', 'name2']; ?>
    @include('form.formBase')
  @endif

  @if($elem == 1)
    <?php $params = ['nickname2', 'birth2', 'birthTime2', 'birthPlace2']; ?>
    @include('form.formBase')
  @endif

@endif

  {{-- ボタンnameで遷移先を制御しているので変更しないこと --}}
  <input type="submit" name="btn_check" value="占う" /><br>
</form>





@endsection