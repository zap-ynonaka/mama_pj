<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
  @include('layout.app.head')
</head>
<body>
  @include('layout.app.header')
<main>
<section class="top__famillyImg">
  <h2 class="title-top__base"><div><span><?php echo date('n月j日') ?><br>今日のおすすめ</span></div></h2>
  <div class="content-space__top">
    <ul class="list-article__base">
      @foreach (@$pickup_top as $p)
      <li @if($loop->first) class="pickup" @endif>
        <a href="/contents/result/{{@$p['id']}}">
          <div><img src="http://placehold.jp/375x200.png" alt=""></div>
          <!--  メニュー画像ができたら差し替え？        <div><img src="/images/menu{{@$p['id']}}.png" alt=""></div> -->
          <p>{{@$p['menu_name']}}</p>
        </a>
      </li>
      @endforeach
    </ul>
  </div>
</section>

<section>
  <h2 class="title-top__base"><div><span>毎日チェック<br><?php echo date('n月j日') ?>の運勢</span></div></h2>
  <div class="content-space__top">


  @if(@$day_result)
    <ul class="js-tab-list tab-list">
      @foreach (@$day_result as $r)
      <li @if($loop->first) class="js-active" @endif><span>{{@$r['menu_name']}}</span></li>
      @endforeach
    </ul>
  @else
    <div class="guest-fortune">
      <h3>あなたの生年月日を入力</h3>
      <form action="">
        <?php $params = ['birth']; ?>
        <input type="hidden" name="fingerprint_id" id="fingerprint_id">{{-- 値はjsで設定 --}}
        @include('form.formBase')
        <style>input[name="birthday"]{display:none;}</style>
        <div class="form-submit__submit">
          <input type="submit" value="今日の運勢を占う">
        </div>

        <!-- <input id="date" type="date" name="birthday">
        <input type="submit" value="今日の運勢を占う"> -->
      </form>
    </div>
  @endif
  @if(@$day_result)
    <ul class="js-tab-area tab-content">
      @foreach (@$day_result as $r)
      <li @if($loop->first) class="js-active" @endif>
        <div class="tab-content__result">
          @if($loop->first)
          {{@$r['summary']}} {{-- 総合運のみサマリー表示 --}}
          @else
          {{@$r['text1']}}
          @endif
        </div>
        <div class="tab-content__recommend">
          <h3 class="title-top__base icon-cameraImg">今日のラッキーフォト</h3>
          <p>子供のパジャマすたがの写真</p>
        </div>
        <div class="button-base">
          <a href="/contents/list/2">今週の運勢を見る</a>
        </div>
      </li>
      @endforeach
    </ul>
  @endif

  </div>

<script>
$(function() {
    $(".js-tab-list li").click(function() {
        $(".js-tab-list li").removeClass('js-active');
        $(".js-tab-area li").removeClass('js-active');
        var index = $(".js-tab-list li").index(this);
        $(".js-tab-list li").eq(index).addClass('js-active');
        $(".js-tab-area li").eq(index).addClass('js-active');
    });
});
</script>
</section>


<section>
  <h2 class="title-top__base"><div><span>いつでも知りたい<br>Kid's ごきげん予報</span></div></h2>

@if($member)  {{-- Kid's ごきげん予報: 会員用 --}}

  {{-- 子供プロフ登録済み --}}
  @if(@$child_result)

      @foreach (@$child_result as $r)
        {{@$r['icon_imgfile']}}<br> {{-- 子供画像ID --}}
        {{@$r['nickname']}}<br> {{-- 子供名前 --}}
        {{@$r['text1']}}<br> {{-- 結果テキスト --}}
        <br>
      @endforeach

  {{-- 子供プロフ未登録 --}}
  @else
  <div class="content-space__top yellowStripe-bgw">
    <ul class="content-gokigenlist outerside">
      <li>
        <div>
          <img src="/images/icon_kids/baby-boy.png" alt="">
        </div>
        <span>サンプルくん</span>
      </li>
      <li class="">
        <div>
          <img src="/images/icon_kids/baby-boy.png" alt="">
        </div>
        <span>サンプルくん</span>
      </li>
      <li class="">
        <div>
          <img src="/images/icon_kids/baby-boy.png" alt="">
        </div>
        <span>サンプルくん</span>
      </li>
      <li class="">
        <div>
          <img src="/images/icon_kids/baby-boy.png" alt="">
        </div>
        <span>サンプルくん</span>
      </li>
    </ul>
    <ul class="content-gokigenContent">
      <li class="content-catch active">子どものプロフィールを登録すると、今日のごきげんがわかる！的なテキスト。<br>
        登録は生年月日とニックネーム、アイコンを設定するだけ！子どもは5人まで登録できるよ。
        <a href="/user/children">子どものプロフィールを登録する</a>
      </li>
      <li class="content-catch">子どものプロフィールを登録すると、今日のごきげんがわかる！的なテキスト。<br>
        登録は生年月日とニックネーム、アイコンを設定するだけ！子どもは5人まで登録できるよ。
        <a href="/user/children">子どものプロフィールを登録する</a>
      </li>
      <li class="content-catch">子どものプロフィールを登録すると、今日のごきげんがわかる！的なテキスト。<br>
        登録は生年月日とニックネーム、アイコンを設定するだけ！子どもは5人まで登録できるよ。
        <a href="/user/children">子どものプロフィールを登録する</a>
      </li>
      <li class="content-catch">子どものプロフィールを登録すると、今日のごきげんがわかる！的なテキスト。<br>
        登録は生年月日とニックネーム、アイコンを設定するだけ！子どもは5人まで登録できるよ。
        <a href="/user/children">子どものプロフィールを登録する</a>
      </li>
    </ul>
  </div>
  @endif

@else {{-- Kid's ごきげん予報: ゲスト用 --}}

  <div class="content-space__top yellowStripe">
    <div class="content-catch child3">
      <h3><span>子どもの今日のご機嫌がわかる!!</span>Kid's ごきげん予報</h3>
      <ul>
        <li><img src="/images/icon_kids/kids-girl.png" alt=""></li>
        <li><img src="/images/icon_kids/kids.png" alt=""></li>
        <li><img src="/images/icon_kids/boy.png" alt=""></li>
      </ul>
      <p>例）こんなことがわかるよ的な結果テキストサンプルこんなことがわかるよ的な結果テキストサンプル。ユーザー登録（無料）するとこんなことが占えちゃうよん！おぬぬめだよん。</p>
      <div class="button-registration">
          <div><a href="/user/login">ログイン</a></div>
          <div><a href="/user/regist_input">ユーザー登録</a></div>
      </div>
    </div>
  </div>
@endif

</section>


@if(@$pickup_trouble)
<section>
  <h2 class="title-top__base"><div><span>もしかして私だけ？<br>これって大丈夫？</span></div></h2>
  <div class="content-space__top">
    <ul class="list-recommend__base outerside">
      @foreach (@$pickup_trouble as $p)
      <li class="">
        <a href="/contents/result/{{$p['id']}}">
          <div><img src="http://placehold.jp/375x200.png" alt=""></div>
          <!--  メニュー画像ができたら差し替え？        <div><img src="/images/menu{{$p['id']}}.png" alt=""></div> -->
          <p>{{$p['menu_name']}}</p>
        </a>
      </li>
      @endforeach
    </ul>
    <div class="">
      <h2 class="title-sub outerside">カテゴリー別でもっと見る</h2>
      <ul class="list-category2">
      @foreach (@$categories as $c)
        @if($loop->index >= 2) 
        <li><a href="/contents/search/?categories_id={{$c->id}}">{{$c->category_name}}</a></li>
        @endif
      @endforeach
      </ul>
    </div>
      <!-- <div class="button-base">
        <a href="/contents/list/8">もっと見る</a>
      </div> -->
  </div>
</section>
@endif


<section>
  <h2 class="title-top__base"><div><span>うらないたいことの<br>[ハッシュタグ]で探す</span></div></h2>
  <div class="content-space__top">
    <ul class="list-category1">
      @foreach (@$tags as $t)
      <li><a href="/contents/search/?tags_id={{$t->id}}">#{{$t->tag_name}}</a></li>
      @endforeach
    </ul>
  </div>
</section>


@if(@$pickup_own)
<section>
  <h2 class="title-top__base"><div><span>ああああああああ<br>私っていいママ？</span></div></h2>
  <div class="content-space__top">
    <ul class="list-article__base">
      @foreach (@$pickup_own as $p)
      <li class="">
        <a href="/contents/result/{{$p['id']}}">
          <div><img src="http://placehold.jp/375x200.png" alt=""></div>
          <!--  メニュー画像ができたら差し替え？        <div><img src="/images/menu{{$p['id']}}.png" alt=""></div> -->
          <p>{{$p['menu_name']}}</p>
        </a>
      </li>
      @endforeach
    </ul>
  </div>
</section>
@endif

<section>
  <h2 class="title-top__base"><div><span>実は知らない<br>子供の性格</span></div></h2>
  <div class="content-space__top yellowStripe">
    <div class="content-catch child1">
      <h3>子どもの性格診断</h3>
      <p>例）こんなことがわかるよ的な結果テキストサンプルこんなことがわかるよ的な結果テキストサンプル。ユーザー登録（無料）するとこんなことが占えちゃうよん！おぬぬめだよん。</p>
      <h3 class="child2">子ども同士について</h3>
      <p>例）こんなことがわかるよ的な結果テキストサンプルこんなことがわかるよ的な結果テキストサンプル。ユーザー登録（無料）するとこんなことが占えちゃうよん！おぬぬめだよん。</p>
      <div class="button-registration">
        <div><a href="/user/login">ログイン</a></div>
        <div><a href="/user/regist_input">ユーザー登録</a></div>
      </div>
    </div>
  </div>
</section>

@if(@$pickup_affinity)
<section>
  <h2 class="title-top__base"><div><span>ああああああああ<br>相性診断</span></div></h2>
  <div class="content-space__top">
    <ul class="list-article__base">
      @foreach (@$pickup_affinity as $p)
      <li class="">
        <a href="/contents/result/{{$p['id']}}">
          <div><img src="http://placehold.jp/375x200.png" alt=""></div>
          <!--  メニュー画像ができたら差し替え？        <div><img src="/images/menu{{$p['id']}}.png" alt=""></div> -->
          <p>{{$p['menu_name']}}</p>
        </a>
      </li>
      @endforeach
    </ul>
  </div>
</section>
@endif

</main>

@include('layout.app.footer')
<br>
<br>
<a href="/contents/search">B1: メニュー検索</a><br>
<a href="/user/regist_input">D1: ユーザー登録</a><br>
<a href="/user/mypage">E1: マイページ</a><br>
<a href="/user/favorite_list">E10: お気に入り</a><br>
<a href="/user/change_email">E11: メールアドレス変更</a><br>
<a href="/user/change_password">E12: パスワード変更</a><br>
<a href="/user/reissue_password">: パスワード再発行</a><br>
<a href="/user/login">A1: ログイン</a><br>
<a href="/user/logout">A1: ログアウト</a><br>
<a href="/help/terms">A1: 利用規約</a><br>
<a href="/help/privacy">A1: プラポリ</a><br>
<a href="/user/unregist">-: 退会(画面詳細が無い...)</a><br>
※プロフィール系はマイページから遷移<br>
<br>

管理ツール系<br>
<a href="/admin/data">-: CSVデータ管理(画面詳細が無い...とりあえずperlFWに似せてます)</a><br>
<a href="/admin/users">-: ユーザー検索(画面詳細が無い...)</a><br>
<br>

コンテンツ系<br>
<a href="/contents">-: コーナー一覧</a><br>



<br>
※フロント改修について<br>
git は https://github.com/zapbd/mama-uranai です<br>
テンプレートは /srv/www/mama-uranai/resources/views 配下に存在する XXX.blade.php が対象です<br>
<br>
http://mama-uranai.ajapa.jp/user/regist_inputなら<br>
/srv/www/mama-uranai/resources/views/user/regist_input.blade.php が対象テンプレートなります<br>
<br>
fileZilla等で mama-dev.ura.pga.jpホストへ接続、ファイル転送で実装願います<br>
<br>
テンプレートtopのextends('layout.app.master')という記載は<br>
/srv/www/mama-uranai/resources/views/layout/app/master.blade.php を参照している<br>
共通記載はこちらへ記載してください(layout.app.master -> layout.app.head -> ga.blade.phpを参照していますのでその構成はそのままで...)<br>
<br>


結果テキスト(ロジックデータ)の更新<br>
下記でzapを指定<br>
<a href="http://mac.pga.jp/admin/common_admins/csv2db4_2/csv2db4_2.cgi">-: ロジックデータ管理</a><br>


</body>
</html>