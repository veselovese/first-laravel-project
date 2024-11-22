@extends('layout')
@section('content')
@if(session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif
<div class="card text-center mb-3" style="width: 70rem;">
    <div class="card-header">
        Author: {{ $user->name }}
    </div>
    <div class="card-body">
        <h5 class="card-title">{{ $article->name }}</h5>
        <p class="card-text">{{ $article->desc }}</p>
        <div class="d-flex justify-content-end gap-3">
            <a href="/article/{{ $article->id }}/edit" class="btn btn-primary">Edit article</a>
            <form action="/article/{{ $article->id }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-warning">Delete article</button>
            </form>
        </div>

    </div>
</div>
<h4 class="text-center">Add Comment</h4>

@if ($errors->any())
<div class="alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="/comment" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="mb-3">
        <label for="desc" class="form-label">Description</label>
        <input type="text" class="form-control" id="desc" name="desc">
    </div>
    <input type="hidden" name="article_id" value="{{ $article->id }}">
    <button type="submit" class="btn btn-primary">Save comment</button>
</form>

<h4 class="text-center">Comments</h4>
<div class="row">
    @foreach($comments as $comment)
    <div class="col-sm-6 mb-3 mb-sm-0 mt-3 ml-3 mr-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{$comment->name}}</h5>
                <p class="card-text">{{$comment->desc}}</p>
                <a href="/comment/{{$comment->id}}/edit" class="btn btn-primary">Edit comment</a>
                <a href="/comment/{{$comment->id}}/delete" class="btn btn-warning">Delete comment</a>
            </div>
        </div>
    </div>
    @endforeach

</div>

@endsection