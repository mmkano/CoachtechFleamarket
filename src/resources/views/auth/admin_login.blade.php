<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/admin_login.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <img src="{{ asset('images/logo.png') }}" alt="COACHTECHロゴ" class="logo">
    </header>

    <main>
        <div class="login-box">
            <h1 class="title">管理者ログイン</h1>
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="input-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="login-form__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
                <div class="input-group">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password">
                </div>
                <div class="login-form__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
                <button type="submit" class="btn">ログインする</button>
            </form>
        </div>
    </main>
</body>
</html>
