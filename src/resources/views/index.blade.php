<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トップページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <img src="{{ asset('images/logo.svg') }}" alt="COACHTECHロゴ" class="logo">
            <input type="text" placeholder="なにをお探しですか？" class="search-bar">
            <nav class="nav">
                @if(Auth::check())
                    <a href="" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                    <a href="" class="nav-link">マイページ</a>
                    <form id="logout-form" action="" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">ログイン</a>
                    <a href="{{ route('register') }}" class="nav-link">会員登録</a>
                @endif
                <a href="#" class="nav-link sell">出品</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="top-container">
            <div class="tabs">
                <a href="#" class="tab active">おすすめ</a>
                <a href="#" class="tab">マイリスト</a>
            </div>
            <div class="items">
                @for ($i = 0; $i < 10; $i++)
                    <div class="item">
                        <img src="{{ asset('images/default.png') }}" alt="商品画像">
                    </div>
                @endfor
            </div>
        </div>
    </main>
</body>
</html>
