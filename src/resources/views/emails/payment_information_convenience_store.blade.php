<!DOCTYPE html>
<html>
<head>
    <title>コンビニ払いの支払い情報</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/convenience_store.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>取引画面</h1>
        </div>
        <div class="warning">
            <h2 class="important"><i class="fas fa-check"></i>支払いをしてください</h2>
            <p>{{ now()->addDays(7)->format('Y年m月d日') }} 23時59分までに必ずお支払いください。</p>
        </div>

        <h2>支払い情報</h2>
        <div class="payment-info">
            <div class="price-row">
                <p>商品代金:</p>
                <p>¥{{ number_format($item->price) }}</p>
            </div>
            <hr>
            <div class="price-row total">
                <p>支払い金額:</p>
                <p>¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        <div class="payment-method">
            <h2>支払い方法</h2>
            <p>お支払いに必要な番号を発行しました。<br>下記に沿ってお支払いを行ってください。</p>
            <div class="payment-details">
                <p>受付番号: 247110</p>
                <p>確認番号: EC08540169</p>
            </div>
        </div>
        
    </div>
</body>
</html>
