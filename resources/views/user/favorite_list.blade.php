@extends('layout.app.master')
@section('content')

<center>お気に入り占い結果一覧</center><br>

@if(@$favorite)
  @foreach (@$favorite as $f)

{{@$f->menu_name}}<br>
診断日時： {{date('Y年m月d日  h:i',strtotime( @$f->fortune_date ?? '1979-12-18 00:00:00'))}}<br>
<br>

    @if (isset($f->result_text))
      @foreach (@$f->result_text['result_data'] as $result)
        <h3>{{ @$result['title'] }}</h3>
        <div>{!! @$result['text1'] !!}</div>
      @endforeach
    @endif

<br>
<a href="{{@$f->result_url}}">この結果をみる></a>

  @endforeach
@else
  保存したお気に入りがありません<br>
@endif
<br>
<br>



@endsection