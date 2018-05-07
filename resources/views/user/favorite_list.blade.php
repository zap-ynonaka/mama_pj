@extends('layout.app.master')
@section('content')

<h1 class="title-sub">お気に入りの占い結果</h1>

<section class="favorite-list">
  <div class="favorite-list__header">
    <span>登録数:<span class="">50</span>件</span>
    <span class="js-favoBtn"><i class="js-active">編集</i><i>キャンセル</i></span>
  </div>

  <form action="/user/favorite_delete" method="post">
    {{ csrf_field() }}
    <ul class="favorite-list__main">
      @if(@$favorite)
      @foreach (@$favorite as $f)
      <li>
        <a href="{{@$f->result_url}}">
          <div class="favorite-list__img"><img src="https://placehold.jp/26/3d4070/ffffff/340x120.png" alt=""></div>
          <div class="favorite-list__text">{{$f->menu_name}}{!! @$result['text1'] !!}</div>
        </a>
        <div class="favorite-list__del">
          <label>
            <input type="checkbox" name="favorite_id[]" value="{{@$f->id}}">
            <span><img src="/images/icon/icon_check.png" alt=""></span></label>
        </div>
      </li>
      @endforeach
      @else
        保存したお気に入りがありません<br>
      @endif
    </ul>

    <div class="pager-base">
      ページャーコの辺かな？
    </div>

    <div class="favo-delete__btn">
      @include('form.formDelete')
    </div>
  </form>

<div class="page-back">
  <a href="/user/mypage">戻る</a>
</div>

</section>

<script>
$(function(){

$('.js-favoBtn').on('click', function(){
  $('.favo-delete__btn').toggleClass('js-active');
  $('.favorite-list__del').toggleClass('js-active');
  $('.js-favoBtn i').toggleClass('js-active');
});


});
</script>




@if(@$favorite)
  @foreach (@$favorite as $f)

{{@$f->menu_name}}<br>
診断日時： {{date('Y年m月d日  h:i',strtotime( @$f->fortune_date ?? '1979-12-18 00:00:00'))}}<br>
<br>

    @if (isset($f->result_text))
      @foreach (@$f->result_text as $result)
        <h3>{{ @$result['title'] }}</h3>
        <div>{!! @$result['text1'] !!}</div>
      @endforeach
    @endif

<br>
<a href="{{@$f->result_url}}">この結果をみる></a>

  @endforeach
@else
  保存したお気に入りがありません<br>
@endif
<br>
<br>



@endsection