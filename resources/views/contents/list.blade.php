@extends('layout.app.master')
@section('content')




<section>
  <ol class="nav-breadcrumb">
  　<li>
      <a href="/">
        <div>
          <img src="http://placehold.jp/30x30.png" alt="">
        </div>
      </a>
    </li>
  　<li>{{@$corners->corner_name}}</li>
  </ol>
</section>

<section>
  <h2 class="title-base">{{@$corners->corner_name}}</h2>
  <div class="second-selectList">
    <a href="">
      <img src="http://placehold.jp/375x200.png" alt="">
      <p>{{@$corners->corner_caption}}</p>
    </a>
  </div>
  <ul class="list-article__base">
    <li class="">
      <a href="#">
        <div>
          <img src="http://placehold.jp/375x200.png" alt="">
        </div>
        <p>他人への感謝の気持ち、どうやって育ててあげればいい？</p>
      </a>
    </li>
    <li class="">
      <a href="#">
        <div>
          <img src="http://placehold.jp/375x200.png" alt="">
        </div>
        <p>他人への感謝の気持ち、どうやって育ててあげればいい？</p>
      </a>
    </li>
    <li class="">
      <a href="#">
        <div>
          <img src="http://placehold.jp/375x200.png" alt="">
        </div>
        <p>他人への感謝の気持ち、どうやって育ててあげればいい？</p>
      </a>
    </li>
    <li class="">
      <a href="#">
        <div>
          <img src="http://placehold.jp/375x200.png" alt="">
        </div>
        <p>他人への感謝の気持ち、どうやって育ててあげればいい？</p>
      </a>
    </li>
    <li class="">
      <a href="#">
        <div>
          <img src="http://placehold.jp/375x200.png" alt="">
        </div>
        <p>他人への感謝の気持ち、どうやって育ててあげればいい？</p>
      </a>
    </li>
  </ul>

</section>


{{@$corners->corner_name}}<br>
<br>
{{@$corners->corner_caption}}<br>
<br>
メニュー一覧<br>


@if (@$menus)
  @foreach (@$menus as $m)
    <a href="/contents/result/{{$m->id}}">{{$m->menu_name}}</a><br>
    @if(@$m->categories->category_name) {{$m->categories->category_name}}<br> @endif
    <br>
  @endforeach
@endif


@endsection