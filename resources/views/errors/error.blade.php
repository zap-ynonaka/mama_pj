@extends('layout.app.master')

@section('content')
<h1 class="pageHeader">{!! $err_title !!}</h1>
<p>
{!! $err_message !!}
</p>
@endsection
