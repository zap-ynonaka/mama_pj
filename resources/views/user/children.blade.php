@extends('layout.app.master')
@section('content')

<h1 class="title-base">子どものプロフィール追加・確認・変更</h1>

<div>
  <h2>子供の情報</h2>
  <dl>

    <dt class="" style="display: flex;">
      <div style="width: 80px;"><img src="https://placehold.jp/50/e0e0e0/e88888/100x100.png?text=%E3%81%8B" alt=""></div>
      <div style="flex: 1;"><span>かりんちゃん</span></div>
    </dt>
    <dd class="children-form__1">
      <div class="mypage-form">
        <form action="#">
          <div style="width: 80px;margin: auto;">
          <input type="radio" name="form-img" /><input type="radio" name="form-img" id="form-img" /><input type="radio" name="form-img" id="form-img" /></div><br><br>

          <span>ニックネーム</span><br>
          <input type="text" name="nickname" value="" /><br><br>

          <span>性別</span><br>
          <label>女の子</label>
          <input type="radio" name="gender" />
          <label>男の子</label><br>
          <input type="radio" name="gender" /><br><br>

          <span>生まれ順</span><br>
          <select>
            <option value="1">てっぺん</option>
            <option value="2" selected="selected">の次</option>
            <option value="3">の次の次</option>
            <option value="4">下から２番目</option>
            <option value="5">一番下</option>
          </select><br><br>


          <span>生年月日</span><br>
          <input type="text" id="form-birthDay__year" value="1986" />年
          <input type="text" id="form-birthDay__month" value="02" />月
          <input type="text" id="form-birthDay__day" value="02" />日<br><br>

          <span>出生時間</span>
          <input type="text" id="form-birthTime__hour" value="13" />時
          <input type="text" id="form-birthTime__minute" value="00" />分<br><br>

          <span>出生地</span>
          <select>
            <option value="614">北海道</option>
            <option value="611">青森県</option>
            <option value="608">岩手県</option>
            <option value="606">秋田県</option>
            <option value="605">山形県</option>
            <option value="602">宮城県</option>
            <option value="600">福島県</option>

            <option value="524">茨城県</option>
            <option value="520">栃木県</option>
            <option value="518">群馬県</option>
            <option value="517">埼玉県</option>
            <option value="511">千葉県</option>
            <option value="507" selected="selected">東京都</option>
            <option value="503">神奈川県</option>

            <option value="415">山梨県</option>
            <option value="414">新潟県</option>
            <option value="412">長野県</option>
            <option value="410">富山県</option>
            <option value="408">石川県</option>
            <option value="407">福井県</option>
            <option value="404">静岡県</option>
            <option value="402">愛知県</option>
            <option value="400">岐阜県</option>

            <option value="310">京都府</option>
            <option value="308">奈良県</option>
            <option value="306">和歌山県</option>
            <option value="305">三重県</option>
            <option value="304">滋賀県</option>
            <option value="302">大阪府</option>
            <option value="300">兵庫県</option>

            <option value="210">岡山県</option>
            <option value="209">鳥取県</option>
            <option value="208">広島県</option>
            <option value="207">島根県</option>
            <option value="205">山口県</option>
            <option value="204">香川県</option>
            <option value="203">徳島県</option>
            <option value="201">愛媛県</option>
            <option value="200">高知県</option>

            <option value="114">福岡県</option>
            <option value="113">佐賀県</option>
            <option value="112">長崎県</option>
            <option value="110">大分県</option>
            <option value="107">熊本県</option>
            <option value="106">宮崎県</option>
            <option value="104">鹿児島県</option>
            <option value="102">沖縄県</option>
            <option value="000">その他</option>

          </select><br>
          <input type="text" id="form-birthPlace" /><br><br>

        </form>

        <div>
          <button id="js-form__checkBtn">確認する</button>
          <button>登録情報を削除する</button>
        </div>

      </div>
    </dd>
  </dl>
</div>

<button id="ajax">ajax</button>

<div id="json"></div>
<script type="text/javascript">

$(function(){
  $('#ajax').on('click',function(){
    $.ajax({
      url:'/api/children/list',
      type:'GET',
      dataType: 'json',
      success: function(json){
        $('dl:nth-of-type(1) form input[name=nickname]').val(json[0].nickname);
        $('#json').append(json[0].nickname + '　');
        $('#json').append(json[0].gender + '　');
        $('#json').append(json[0].birthorder + '　');
        $('#json').append(json[0].birthday + '　');
        $('#json').append(json[0].birthtime_unknown + '　');
        $('#json').append(json[0].birthtime + '　');
        $('#json').append(json[0].from_pref + '　');
      }
    });
  });
});

</script>
<p>
接続: get<br>
入力: users_id (ユーザーID)<br>
URL: <br>
http://macomo.ajapa.jp/api/children/list<br>
https://macomo.me/api/children/list<br>

※環境で当然URL変化します<br>
出力:色々。下記を実行して確認してください。形式はjsonです<br>
http://macomo.ajapa.jp/api/children/list<br>


・子供作成<br>
URL: /api/children/insert<br>
(開発:http://macomo.ajapa.jp/api/children/insert 本番:https://macomo.me/api/children/insert)<br>
接続: POST<br>
入力: <br>
子供ID         id (idだけ必須、他任意)<br>
アイコン画像    icon_imgfile<br>
アイコン背景色    icon_backcolor<br>
入力パラメータ(ニックネーム)    nickname<br>
入力パラメータ(苗字)    last_name<br>
入力パラメータ(苗字かな)    last_name_kana<br>
入力パラメータ(名前)    first_name<br>
入力パラメータ(名前かな)    first_name_kana<br>
入力パラメータ(生年月日)    birthday<br>
入力パラメータ(出生時間)    birthtime<br>
入力パラメータ(出生時間不明フラグ)    birthtime_unknown<br>
入力パラメータ(生まれ順)    birthorder<br>
入力パラメータ(血液型)    blood<br>
入力パラメータ(性別)    gender<br>
入力パラメータ(出生地)    from_pref<br>
<br>

出力: 'response' => 'OK'<br><br><br><br>

・子供編集<br>
/api/children/edit<br>
接続: POST<br>
入力:<br>
子供ID         id (idだけ必須、他任意)<br>
アイコン画像    icon_imgfile<br>
アイコン背景色    icon_backcolor<br>
入力パラメータ(ニックネーム)    nickname<br>
入力パラメータ(苗字)    last_name<br>
入力パラメータ(苗字かな)    last_name_kana<br>
入力パラメータ(名前)    first_name<br>
入力パラメータ(名前かな)    first_name_kana<br>
入力パラメータ(生年月日)    birthday<br>
入力パラメータ(出生時間)    birthtime<br>
入力パラメータ(出生時間不明フラグ)    birthtime_unknown<br>
入力パラメータ(生まれ順)    birthorder<br>
入力パラメータ(血液型)    blood<br>
入力パラメータ(性別)    gender<br>
入力パラメータ(出生地)    from_pref<br>
<br>
出力: 'response' => 'OK'<br><br><br><br>

・子供削除<br>
/api/children/delete<br>
接続: POST<br>
入力: id (子供ID 必須)<br>
出力: 'response' => 'OK'<br>
</p>




@endsection