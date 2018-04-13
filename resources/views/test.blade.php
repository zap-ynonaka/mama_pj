<!doctype html>
<html lang="ja">
<head><meta charset="utf-8"></head>
<body>

<h1>初回テストページ</h1><br>
<br>

・DB取得結果: {{ $db_res ?? '' }}<br>
<br>

・メール送信先: {{ $res_mail ?? '' }}<br>
<br>

・ロジック接続: {{ $res_logic ?? '' }}<br>
<br>

<form id="js-generalForm" method="post" action="/user/regist_mailsend">
  {{ csrf_field() }}
  <button type="submit" class="submit common-bg-01" onclick="ga('send', 'event', 'cv2', 'click', '{$name|default:"不明"|escape}/メールアドレス', true);document.forms[0].elements['email_e'].value=encodeURIComponent(document.forms[0].elements['email'].value);">
    <div class="submit-btn">POST送信</div>
  </button>

</form>

</body>
</html>
