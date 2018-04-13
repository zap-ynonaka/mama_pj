<!doctype html>
<html lang="ja">
<head><meta charset="utf-8"></head>
<link href="css/app.css" rel="stylesheet" type="text/css">
<body>

<h1>初回テストページ</h1><br>
<br>

・DB取得結果: {{ $db_res ?? '' }}<br>
<br>

・メール送信先: {{ $res_mail ?? '' }}<br>
<br>

・ロジック接続: {{ $res_logic ?? '' }}<br>
<br>

</body>
</html>
