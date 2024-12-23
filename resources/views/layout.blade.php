<!doctype html>
<html lang="ru">

<head>
    <title>Веселов 231-322</title>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/article">Статьи</a>
                        </li>
                        @can('update')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/article/create">Создать статью</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/comment/admin">Модерация комментариев</a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/about">О нас</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/contacts">Контакты</a>
                        </li>
                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Уведомления {{auth()->user()->unreadNotifications->count()}}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                <li><a class="dropdown-item" href="{{route('article.show', ['article' => $notification->data['article']['id'], 'notify' => $notification->id])}}">{{ $notification->data['article']['name'] }}{{ $notification->data['comment_name'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endauth
                    </ul>
                    @guest
                    <a class="btn btn-outline-success me-1  " href="/auth/signin">Войти</a>
                    <a class="btn btn-outline-success me-1" href="/auth/signup">Зарегистрироваться</a>
                    @endguest
                    @auth
                    <a class="btn btn-outline-success" href="/auth/logout">Выйти</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container mt-3">
            <div id="app">
                <App />
            </div>
            @yield('content')
        </div>
    </main>
    <footer>
    </footer>
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>