@extends('layout')
@section('content')

@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger" role="alert">{{$error}}</div>
@endforeach
@endif

<form action="/auth/registr" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Имя</label>
        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Почта</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Оставаться в системе</label>
    </div>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>
@endsection