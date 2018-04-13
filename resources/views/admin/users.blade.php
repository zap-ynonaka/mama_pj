@extends('layout.app.master')
@section('content')

<center>ユーザー一覧</center><br>


@if(@$users)
<table>
<thead>
<tr><th>ID</th><th>email</th><th>ニックネーム</th><th>生年月日</th></tr>
</thead>
</table>

<table>
<tbody>
  @foreach (@$users as $u)

  <tr><td>{{@$u->id}}</td><td>{{@$u->email}}</td><td>{{@$u->nickname}}</td><td>{{@$u->birthday}}</td></tr>

  @endforeach
</tbody>
</table>
@else
  該当ユーザーがありません<br>
@endif


<br>
<br>

・ユーザのアカウント・プロフィールの閲覧ができる
多分一覧 -> 詳細の流れなのだろうが、どちらの画面にどの項目を表示するかで実装が変化

@endsection