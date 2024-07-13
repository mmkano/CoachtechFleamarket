<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/layouts/admin.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <a href="{{ route('admin.users') }}">
            <img src="{{ asset('images/logo.png') }}" alt="COACHTECHロゴ" class="logo">
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <button class="logout-button" onclick="document.getElementById('logout-form').submit();">ログアウト</button>
    </header>

    <main>
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>