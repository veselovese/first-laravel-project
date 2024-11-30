@extends('layout')
@section('content')
@use('App\Models\User', 'User')
@use('App\Models\Article', 'Article')

@if(session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

<table class="table">
    <thead>
        <tr>
            <th scope="col">Дата</th>
            <th scope="col">Имя</th>
            <th scope="col">Описание</th>
            <th scope="col">Автор</th>
            <th scope="col">Действие</th>
        </tr>
    </thead>
    <tbody>
        @foreach($comments as $comment)
        <tr>
            <th scope="row">{{ $comment -> created_at }}</th>
            <td><a href="/article/{{ $comment->article_id }}">{{ Article::findOrFail($comment->article_id)->name }}</a></td>
            <td>{{ $comment -> desc }}</td>
            <td>{{ User::findOrFail($comment->user_id)->name }}</td>
            <td class="">
                @if(!$comment->accept)
                <a class="btn btn-success" href="/comment/{{$comment->id}}/accept">Принять</a>
                @else
                <a class="btn btn-danger" href="/comment/{{$comment->id}}/reject">Отклонить</a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $comments->links() }}
@endsection