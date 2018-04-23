@extends('layout.app.master')
@section('content')

メニュー検索<br>
<br>
<form action="/contents/search" method="post">
  {{ csrf_field() }}

{{-- コーナー一覧 --}}
<select name="corners_id">
    <option value="0">未選択</option>
@foreach (@$corners as $c)
    <option value="{{$c->id}}" @if(@$corners_id == $c->id) selected @endif>{{$c->corner_name}}</option>
@endforeach
</select>
&nbsp;&nbsp;
{{-- カテゴリー一覧 --}}
<select name="categories_id">
    <option value="0">未選択</option>
@foreach (@$categories as $c)
    <option value="{{$c->id}}" @if(@$categories_id == $c->id) selected @endif>{{$c->category_name}}</option>
@endforeach
</select>

&nbsp;&nbsp;
<input type="submit" name="btn_complete" value="検索する" /><br>

</form>


{{-- タグ一覧 --}}
@foreach (@$tags as $t)
    <a href="/contents/search?tags_id={{$t->id}}">{{$t->tag_name}}</a>&nbsp;
@endforeach
<br><br>


検索結果<br>
<br>
  @if(@$menus)
  @foreach (@$menus as $m)
      <a href="/contents/result/{{$m->id}}">{{$m->menu_name}}</a><br>
  @endforeach
  @endif
@endsection