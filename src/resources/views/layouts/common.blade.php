<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COACHTECH')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <img src="{{ asset('images/logo.svg') }}" alt="COACHTECHロゴ" class="logo">
            <input type="text" placeholder="なにをお探しですか？" class="search-bar {{ Auth::check() ? 'logged-in' : 'logged-out' }}">
            <nav class="nav">
                @if(Auth::check())
                    <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                    <a href="" class="nav-link">マイページ</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">ログイン</a>
                    <a href="{{ route('register') }}" class="nav-link">会員登録</a>
                @endif
                <a href="{{ route('create') }}" class="nav-link sell">出品</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
