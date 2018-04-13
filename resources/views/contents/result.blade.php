@extends('layout.app.master')
@section('content')

メニュー名:{{@$menu_name}}<br>
<br>
サマリー:{{@$result['summary']}}<br>
<br>
結果テキスト:{{@$result['text1']}}<br>
<br>
結果保存する<br>
<br>
メール・LINE・ツイッター<br>
@endsection