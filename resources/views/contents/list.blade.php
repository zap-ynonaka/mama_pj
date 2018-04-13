@extends('layout.app.master')
@section('content')



{{@$corners->corner_name}}<br>
<br>
{{@$corners->corner_caption}}<br>
<br>
メニュー一覧<br>


@if (@$menus)
  @foreach (@$menus as $m)
    <a href="/contents/result/{{$m->id}}">{{$m->menu_name}}</a><br>
    @if(@$m->categories->category_name) {{$m->categories->category_name}}<br> @endif
    <br>
  @endforeach
@endif


@endsection