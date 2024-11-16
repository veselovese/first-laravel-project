@extends('layout')
@section('content')
<table class="table">
    <thead>
        <tr>
            <th scope="col">Дата</th>
            <th scope="col">Имя</th>
            <th scope="col">Описание</th>
            <th scope="col">Автор</th>
        </tr>
    </thead>
    <tbody>
        @foreach($articles as $article)
        <tr>
            <th scope="row">{{ $article -> date }}</th>
            <td>{{ $article -> name }}</td>
            <td>{{ $article -> desc }}</td>
            <td>
                @php
                echo \App\Models\User::findOrFail($article->user_id)->name
                @endphp
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection