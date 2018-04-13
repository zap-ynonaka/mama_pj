@extends('layout.app.master')
@section('content')

    <center>DBデータ管理</center><br>
@if(@$complete_mess) {{@$complete_mess}}<br><br> @endif


    csvダウンロード<br>
    <form action="/admin/data" method="post">
        {{ csrf_field() }}
        <select name="table">
          @if(@$tables) @foreach (@$tables as $t)
            <option value="{{$t}}">{{$t}}</option>
          @endforeach @endif
        </select>
      <button type="submit" name="btn_download" value="1">CSV DL</button>
    </form>
    <br>
    <br>
    csvアップロード<br>
    <form action="/admin/data" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="radio" name="mode" value="update" checked>更新&nbsp;&nbsp;
      <input type="radio" name="mode" value="delete">削除<br>
      <input type="file" id="file" name="file" required>
      <button type="submit" name="btn_upload" value="1">CSV UP</button>
    </form>
<br>
<br>
macとcsv相性悪いので、mac上でDLしたcsvファイルを複数回保存・更新をするとcsv形式がどんどんおかしくなります。<br>
基本的にはcsvDL直後から一度の更新で反映するようご注意ください<br>
<br>

@endsection
