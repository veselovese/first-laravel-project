@extends('layout')
@section('content')
<p>{{ $name }}</p>
<img src="/{{ $img }}" alt="" class="img-thumbnail">
@endsection