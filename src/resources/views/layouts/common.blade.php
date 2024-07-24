<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device=width, initial-scale=1.0">
    <title>@yield('title', 'COACHTECH')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="COACHTECHロゴ" class="logo">
            </a>
            <form action="{{ route('items.search') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="なにをお探しですか？" class="search-bar {{ Auth::check() ? 'logged-in' : 'logged-out' }}" value="{{ request('search') }}">
                <div class="search-dropdown">
                    <div class="search-category">
                        <a href="{{ route('items.search.category') }}">カテゴリーからさがす</a>
                    </div>
                    <div class="search-condition">
                        <a href="{{ route('items.search.condition') }}">商品状態からさがす</a>
                    </div>
                    <div class="search-brand">
                        <a href="{{ route('items.search.brand') }}">ブランドからさがす</a>
                    </div>
                    <div class="price-range">
                        <input type="number" name="min_price" placeholder="¥最小価格" value="{{ request('min_price') }}">
                        <span>-</span>
                        <input type="number" name="max_price" placeholder="¥最大価格" value="{{ request('max_price') }}">
                        <button type="submit" class="search-button">検索</button>
                    </div>
                </div>
            </form>
            <nav class="nav">
                @if(Auth::check())
                    <a href="{{ route('logout') }}" class="nav-link logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                    <a href="{{ route('mypage') }}" class="nav-link">マイページ</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link login">ログイン</a>
                    <a href="{{ route('register') }}" class="nav-link">会員登録</a>
                @endif
                
                @auth
                    <a href="{{ route('create') }}" class="nav-link sell">出品</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link sell">出品</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBar = document.querySelector('.search-bar');
            const searchDropdown = document.querySelector('.search-dropdown');

            searchBar.addEventListener('focus', function() {
                searchDropdown.style.display = 'block';
            });

            document.addEventListener('click', function(event) {
                if (!searchBar.contains(event.target) && !searchDropdown.contains(event.target)) {
                    searchDropdown.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
