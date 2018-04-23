@extends('layout.app.master')
@section('content')


<nav>
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
</nav>

<section>
  <h1 class="title-base">{{@$corners->corner_name}}</h1>
  <div class="second-selectList">
    <img src="http://placehold.jp/375x200.png" alt="">
    <p>{{@$corners->corner_caption}}</p>
  </div>
  <ul class="list-article__base">
  @if (@$menus)
    @foreach (@$menus as $m)
    <li class="">
      <a href="/contents/result/{{$m->id}}">
        <div>
          <img src="http://placehold.jp/375x200.png" alt="">
        </div>
        <p>{{$m->menu_name}}</p>
      </a>
    </li>
    @if(@$m->categories->category_name) {{$m->categories->category_name}}<br> @endif
    @endforeach
  @endif
  </ul>

</section>





@endsection