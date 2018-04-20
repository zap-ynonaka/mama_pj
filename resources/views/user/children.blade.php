@extends('layout.app.master')
@section('content')

<h1 class="title-second__main">子どものプロフィール追加・確認・変更</h1>


<div class="form-main">
<div class="form-check__massage">まだプロフィールが登録されていません。</div>
  <h2 class="title-second__sub">子供の情報</h2>
  <dl class="form-list">

    <dt class="form-child form-child__new">
      <div class="form-child__img"><img src="#" alt=""></div>
      <div class="form-child__name"><span>新しく追加する</span></div>
    </dt>
    <dd class="form-content">
      <div class="mypage-form">

        <form action="/user/children_profile" method="post">
        <?php $params = ['id', 'img', 'nickname', 'gender', 'blood', 'birthOrder', 'birth', 'birthTime', 'birthPlace']; ?>
        @include('form.formBase')
        </form>

      </div>
    </dd>

    <dt class="form-child">
      <div class="form-child__img"><img src="#" alt=""></div>
      <div class="form-child__name"><span>かりんちゃん</span></div>
    </dt>
    <dd class="form-content">
      <div class="mypage-form">

        <form action="/user/children_profile" method="post">
        <?php $params = ['id', 'img', 'nickname', 'gender', 'blood', 'birthOrder', 'birth', 'birthTime', 'birthPlace']; ?>
        @include('form.formBase')
        </form>

      </div>
    </dd>

    <dt class="form-child">
      <div class="form-child__img"><img src="#" alt=""></div>
      <div class="form-child__name"><span>かりんちゃん</span></div>
    </dt>
    <dd class="form-content">
      <div class="mypage-form">

        <form action="/user/children_profile" method="post">
        <?php $params = ['id', 'img', 'nickname', 'gender', 'blood', 'birthOrder', 'birth', 'birthTime', 'birthPlace']; ?>
        @include('form.formBase')
        </form>

      </div>
    </dd>

    <dt class="form-child">
      <div class="form-child__img"><img src="#" alt=""></div>
      <div class="form-child__name"><span>かりんちゃん</span></div>
    </dt>
    <dd class="form-content">
      <div class="mypage-form">

        <form action="/user/children_profile" method="post">
        <?php $params = ['id', 'img', 'nickname', 'gender', 'blood', 'birthOrder', 'birth', 'birthTime', 'birthPlace']; ?>
        @include('form.formBase')
        </form>

      </div>
    </dd>

    <dt class="form-child">
      <div class="form-child__img"><img src="#" alt=""></div>
      <div class="form-child__name"><span>かりんちゃん</span></div>
    </dt>
    <dd class="form-content">
      <div class="mypage-form">

        <form action="/user/children_profile" method="post">
        <?php $params = ['id', 'img', 'nickname', 'gender', 'blood', 'birthOrder', 'birth', 'birthTime', 'birthPlace']; ?>
        @include('form.formBase')
        </form>

      </div>
    </dd>

    <dt class="form-child">
      <div class="form-child__img"><img src="#" alt=""></div>
      <div class="form-child__name"><span>かりんちゃん</span></div>
    </dt>
    <dd class="form-content">
      <div class="mypage-form">

        <form action="/user/children_profile" method="post">
        <?php $params = ['id', 'img', 'nickname', 'gender', 'blood', 'birthOrder', 'birth', 'birthTime', 'birthPlace']; ?>
        @include('form.formBase')
        </form>

      </div>
    </dd>



  </dl>
</div>

<button id="ajax">ajax</button>

<div id="json"></div><br><br><br><br><br><br><br>
<script type="text/javascript">

$(function(){

  $.ajax({
    url:'/api/children/list',
    type:'GET',
    dataType: 'json',
    success: function(json){
      var len = Object.keys(json).length - 1 ;
      console.log(len);
      if( len == 0 ) {
        $('.form-child__new').css('display', 'flex');
        console.log(0);
      } else if ( len < 4 ) {
        var target = $('.form-child:nth-of-type('+len+')');
        $(target).css('display', 'flex');
        console.log(4);
      } else {
        $('.form-child__new').css('display', 'none');
        console.log(5);
      }
    }
  });


  $('.form-main dl dt').on('click',function(){

    // ペン付きimgタップでフォーム切替
    $('.js-img__submit').on('click', function(){
      $('.form-item__imgFix').css('display', 'block');
      $('.form-item__img').css('display', 'none');
    });
    $('.form-item__imgFix').on('click', function(){
      $('.form-item__imgFix').css('display', 'none');
      $('.form-item__img').css('display', 'flex');
    });
    // img　タップで切り替え
    $('.form-item__img > div').on('click', function(){
      $('.form-item__img > div').removeClass('js-active');
      $(this).addClass('js-active');
      console.log($(this).children);
    });

    $('.form-main dl dd').removeClass('js-form__open');
    $(this).next().addClass('js-form__open');

    $.ajax({
      url:'/api/children/list',
      type:'GET',
      dataType: 'json',
      success: function(json){

        // id
        $('dl:nth-of-type(1) form input[name=userid]').val(json[0].id);

         // icon
         $('dl:nth-of-type(1) form input[name=imgfile]').val(json[0].icon_imgfile);

        //　ニックネーム
        $('dl:nth-of-type(1) form input[name=nickname]').val(json[0].nickname);
        $('#json').append(json[0].nickname + '　');
        var jsonId = json[0].id;

        // 誕生日
        var birthDayY = Number( json[0].birthday.slice(0, 4) ),
            birthDayM = Number( json[0].birthday.slice(5, 7) ),
            birthDayD = Number( json[0].birthday.slice(8, 10) );

        for(var i = 0;i <= $('.form-birthDay__year option').length; i++) {
          var dYval = $('.form-birthDay__year option:nth-of-type('+i+')');
          if( birthDayY == $(dYval).val() ) {
            $(dYval).prop('selected',true);
          }
        }

        // 性別
        if ( json[0].gender === 'f' ) {
          $('dl:nth-of-type(1) form input.form-gender__f').prop('checked',true);
        } else {
          $('dl:nth-of-type(1) form input.form-gender__m').prop('checked',true);
        }
        $('#json').append(json[0].gender + '　');

        //　生まれ順
        switch ( json[0].birthorder ){
          case '1':
            $('dl:nth-of-type(1) form .form-item__birthOrder option:nth-of-type(1)').prop('selected',true);
            break;
          case '2':
            $('dl:nth-of-type(1) form .form-item__birthOrder option:nth-of-type(2)').prop('selected',true);
            break;
          case '3':
            $('dl:nth-of-type(1) form .form-item__birthOrder option:nth-of-type(3)').prop('selected',true);
            break;
          case '4':
            $('dl:nth-of-type(1) form .form-item__birthOrder option:nth-of-type(4)').prop('selected',true);
            break;
          case '5':
            $('dl:nth-of-type(1) form .form-item__birthOrder option:nth-of-type(5)').prop('selected',true);
            break;
          default:
            console.log("動いてないよー！");
            break;
        }
        $('#json').append(json[0].birthorder + '　');

        // 誕生日
        var birthDayY = Number( json[0].birthday.slice(0, 4) ),
            birthDayM = Number( json[0].birthday.slice(5, 7) ),
            birthDayD = Number( json[0].birthday.slice(8, 10) );

        for(var i = 0;i <= $('.form-birthDay__year option').length; i++) {
          var dYval = $('.form-birthDay__year option:nth-of-type('+i+')');
          if( birthDayY == $(dYval).val() ) {
            $(dYval).prop('selected',true);
          }
        }
        for(var i = 0;i <= $('.form-birthDay__month option').length; i++) {
          var dMval = $('.form-birthDay__month option:nth-of-type('+i+')');
          if( birthDayM == $(dMval).val() ) {
            $(dMval).prop('selected',true);
          }
        }
        for(var i = 0;i <= $('.form-birthDay__day option').length; i++) {
          var dDval = $('.form-birthDay__day option:nth-of-type('+i+')');
          if( birthDayD == $(dDval).val() ) {
            $(dDval).prop('selected',true);
          }
        }
        $('#json').append(json[0].birthday + '　');

        //　出生時間
        var birthTimeH = Number( json[0].birthtime.slice(0, 2) ),
            birthTimeM = Number( json[0].birthtime.slice(3, 5) );
            console.log(birthTimeH, birthTimeM);
        if( $('dl:nth-of-type(1) form input[name=birthtime_unknown]') == 1) {
          $('.form-birthTime__hour option:nth-of-type(1)').prop('selected',true);
          $('.form-birthTime__minute option:nth-of-type(1)').prop('selected',true);
        } else {
          for(var i = 0;i <= $('.form-birthTime__hour option').length; i++) {
            var tHval = $('.form-birthTime__hour option:nth-of-type('+i+')');
            if( birthTimeH == $(tHval).val() ) {
              $(tHval).prop('selected',true);
            }
          }

          for(var i = 0;i <= $('.form-birthTime__minute option').length; i++) {
            var tMval = $('.form-birthTime__minute option:nth-of-type('+i+')');
            if( birthTimeM == $(tMval).val() ) {
              $(tMval).prop('selected',true);
            }
          }
        }
        $('#json').append(json[0].birthtime_unknown + '　');

        //　出生地
        for(var i = 0;i <= $('.form-item__birthPlace option').length; i++) {
          var place = $('.form-item__birthPlace option:nth-of-type('+i+')');
          if( json[0].from_pref == $(place).val() ) {
            $(place).prop('selected',true);
          }
        }
        $('#json').append(json[0].from_pref + '　');

      }
    });
  });
});


$('#js-form__checkBtn').on('click',function(){
  var JSONdata = {
    "id": $('input[name=userid]').val(),
    "nickname": $('dl:nth-of-type(1) form input[name=nickname]').val(),
    "gender": $('input[name=gender]:checked').val(),
    "birthorder": $('.form-item__birthOrder option:selected').val(),
    "birthday": $('.form-item__birth').val() + '-' + $('.form-item__month').val() + '-' + $('.form-item__day').val(),
    "nickname": $('dl:nth-of-type(1) form input[name=nickname]').val(),
  }
  console.log(JSONdata);
  $.ajax({
    url:'/api/children/edit',
    data : JSON.stringify(JSONdata),
    type:'POST',
    contentType: 'application/json',
    dataType: 'json',
    success: function(json) {
      console.log('success');
    }
  })
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