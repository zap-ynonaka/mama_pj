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
        <input type="hidden" name="callbackurl" value="{{@$callbackurl}}">
        <?php $params = ['img', 'nickname', 'gender', 'blood', 'birthOrder', 'birth', 'birthTime', 'birthPlace']; ?>
        @include('form.formBase')

        @include('form.formCheck')

        </form>

      </div>
    </dd>

    @if(@$children)
    @foreach (@$children as $key => $value)

    <dt class="form-child">
      <div class="form-child__img"><img src="/images/icon/children/kids_0{{$value['icon_imgfile']}}.png" alt=""></div>
      <div class="form-child__name"><span>{{$value['nickname']}}</span></div>
    </dt>
    <dd class="form-content">
      <div class="mypage-form">

        <form action="/user/children_profile" method="post">
        <input type="hidden" name="callbackurl" value="{{@$callbackurl}}">
        <?php $params = ['id', 'img', 'nickname', 'gender', 'blood', 'birthOrder', 'birth', 'birthTime', 'birthPlace']; ?>
        @include('form.formBase')

        @include('form.formCheck')

        </form>

        <form action="/user/children_delete" method="post">
          @include('form.formDelete')
        </form>


      </div>
    </dd>
    @endforeach
    @endif


  </dl>
</div>


<script>




$(function(){

var len = $('.form-list dt').length;
if(len == 6) {
  $('.form-child__new').css('display', 'none');
}

$('.form-main dl dt').on('click',function(){
  // クリックされたdtからターゲットのddを選択するため用
  var formNumber = '.form-main dl dd:nth-of-type(' + Number($(this).index() / 2 + 1) + ') ';
  console.log(formNumber);

  // こどもの名前クリックで情報表示
  $('.form-main dl dd').removeClass('js-form__open');
  $(this).next().addClass('js-form__open');


  gender( formNumber );

  blood( formNumber );

  birthOrder( formNumber );

  birthDay( formNumber );

  birthTime( formNumber );

  pref( formNumber );

  childImg( formNumber );


});

});





</script>



@endsection