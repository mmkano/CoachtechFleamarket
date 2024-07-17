<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>支払い情報送信完了</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sent.css') }}">
</head>
<body>
    <header class="header">
    </header>

    <main class="main">
        <div class="payment-sent-container">
            <h1>支払い情報が<br>メールに送信されました</h1>
            <a href="{{ route('home') }}" class="btn btn-primary">戻る</a>
        </div>
    </main>
</body>
</html>

