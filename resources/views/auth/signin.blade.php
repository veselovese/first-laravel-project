@extends('layout')
@section('content')

@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger" role="alert">{{$error}}</div>
@endforeach
@endif

<form action="/auth/authenticate" method="POST">
    @csrf
    <div class="mb-3">  
        <label for="email" class="form-label">Почта</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="remember" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Оставаться в системе</label>
    </div>
    <button type="submit" class="btn btn-primary">Войти</button>
</form>
@endsection