<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入完了</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/complete.css') }}">
</head>
<body>
    <header class="header">
    </header>

    <main>
    <div class="complete-container">
        <h1>購入が完了しました</h1>
        <a href="{{ route('home') }}" class="btn btn-primary">戻る</a>
    </div>
    </main>
</body>
</html>
