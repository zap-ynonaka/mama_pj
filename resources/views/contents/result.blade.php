@extends('layout.app.master')
@section('content')

<section class="second-space2">
  <div class="second-result register-confirm content-space__second">
    <h1 class="title-sub outerside">{{@$menu_name}}</h1>
    <div class="second-result__img outerside"><img src="http://placehold.jp/375x200.png" alt=""></div>
    <div class="second-result__area">
      @if($affinity >= 12 && $affinity != 11)
      <div class="second-result__affinityName">{{@$nickname}}x{{@$nickname2}}の相性診断</div>
      @elseif($affinity < 10 && $affinity != 1)
      <div class="second-result__nickname">{{@$nickname}}</div>
      @endif

      <div class="second-result__text">
      {{-- 結果が子供達など、複数回す場合があるため、かならずfor文を使用　--}}
      @foreach (@$result as $r)

        {{--　子供占いの時だけ個々に名前表示 --}}
        @if($affinity == 1 || $affinity == 11)
          名前:{{@$r['nickname']}}<br>
          <br>
        @endif

          サマリー:{{@$r['summary']}}<br>
          <br>
          結果テキスト:{{@$r['text1']}}<br>
          <br>
          <br>
        @endforeach


        @if(@$favorited_id) {{-- お気に入り済なら表示--}}
        <form action="/user/favorite_delete" method="post">
          {{ csrf_field() }}
          <div class="form-submit__favorite">
            <input type="hidden" name="id" value="{{$favorited_id}}" />
            <input type="hidden" name="menus_id" value="{{$menus_id}}" />
            <input type="submit" name="btn_input" value="結果削除する" />
          </div>
        </form>
        @endif
        @if(!@$not_favorite) {{-- 保存したお気に入りから来る時はボタン非表示--}}
        <form action="/user/favorite_regist" method="post">
          {{ csrf_field() }}
          <div class="form-submit__favorite">
            <input type="hidden" name="menus_id" value="{{$menus_id}}" />
            <input type="submit" name="btn_input" value="結果保存する" />
          </div>
        </form>
        <div class="button-favorite" id="button-favorite_onof">
          <button>結果をお気に入りに追加する</button>
        </div>
        @endif
      </div>
    </div>

    <ul class="second-resultShare">
      <li class="m-icon"><img src="/images/icon_social/share-mail.png" alt=""><a href="">メールで送る</a></li>
      <li class="l-icon"><img src="/images/icon_social/share-line.png" alt=""><a href="">LINEで送る</a></li>
      <li class="t-icon"><img src="/images/icon_social/share-twitter.png" alt=""><a href="">ツイートする</a></li>
    </ul>

  </div>

  <div class="page-back"><a href="/">戻る</a></div>

</section>

<script>
$(function(){
    var def = "default";
    $('#button-favorite_onof').click(function(){
          if(def == "default"){
              $(".button-favorite").addClass("js-active");              
              $('#button-favorite_onof button').html("お気に入りから削除する");
              def = "changed";
            }else{
              $(".button-favorite").removeClass("js-active");
              $('#button-favorite_onof button').html("結果をお気に入りに追加する");
              def = "default";
            }
    });
});
</script>

@endsection