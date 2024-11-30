<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новый комментарий</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
            line-height: 1.5;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Был добавлен новый комментарий</h1>
        <p>Статья: <a href="http://127.0.0.1:3000/article/{{$article->id}}">{{ $article->name }}</a></p>
        <p>Текст комментария: {{ $comment->desc }}</p>
        <p>Модерация по ссылке:</p>
        <a href="http://127.0.0.1:3000/comment/admin" class="btn">Принять</a>
    </div>
</body>
</html>