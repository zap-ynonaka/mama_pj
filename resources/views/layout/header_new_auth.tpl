<!DOCTYPE HTML>
<html lang="ja">
  <head>
    <meta charset="Shift_JIS">
    <meta http-equiv="Content-Type" content="text/html">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <title>{$title}</title>
    <meta name="description" content="共通管理画面">
    <meta name="author" content="株式会社ザッパラス">
    <meta name="copyright" content="Copyright &#169; ZAPPALLAS,INC ALL RIGHTS RESERVED.">
    <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1, maximum-scale=2, user-scalable=no">
      {if $new_authentication_change}
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="shortcut icon" href="https://help.cocoloni.jp/image/favicon.sp.480.png">
        <link rel="stylesheet" type="text/css" href="/css/new_authentication_change.css">
        <link rel="stylesheet" type="text/css" href="/css/web_css.css">
      {else}
        <link rel="stylesheet" type="text/css" media="screen" href="/css/reset.css">
        <link rel="stylesheet" type="text/css" media="screen" href="/css/payauth{if $newAuth}_OldFW{/if}.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
      {/if}
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="wrapper">
      <header class="header">
        <h1 class="header__title">{$name}</h1>
      </header>

{if $new_authentication_change}

        <main class="main change-area" id="main">
{else}
        <main class="main" id="main">
{/if}
        <section class="section">
          <h1 class="subhead">{$sub_head}</h1>
