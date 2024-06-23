<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>住所変更ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
</head>
<body>
    <header class="header">
    </header>

    <main>
        <div class="create-item-container">
            <h1>商品の出品</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <label for="img_url">商品画像</label>
                    <div class="file-input-container">
                        <input type="file" id="img_url" name="img_url" accept="image/*" class="file-input">
                        <label for="img_url" class="file-input-label">画像を選択する</label>
                    </div>
                </div>
                <div class="ttl">
                    <h2>商品の説明</h2>
                </div>
                <div class="input-group">
                    <label for="category_item_id">カテゴリー</label>
                    <input type="text" id="category_item_id" name="category_item_id">
                </div>
                <div class="input-group">
                    <label for="condition_id">商品の状態</label>
                    <input type="text" id="condition_id" name="condition_id">
                </div>
                <div class="ttl">
                    <h2>商品名と説明</h2>
                </div>
                <div class="input-group">
                    <label for="name">商品名</label>
                    <input type="text" id="name" name="name">
                </div>
                <div class="input-group">
                    <label for="description">商品の説明</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <div class="ttl">
                    <h2>販売価格</h2>
                </div>
                <div class="input-group">
                    <label for="price">販売価格</label>
                    <div class="price-container">
                        <input type="text" id="price" name="price" class="price-input">
                    </div>
                </div>
                <button type="submit" class="submit-button">出品する</button>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const priceInput = document.getElementById('price');
            const yenSymbol = '¥';

            if (!priceInput.value.startsWith(yenSymbol)) {
                priceInput.value = yenSymbol;
            }

            priceInput.addEventListener('input', function () {
                if (!this.value.startsWith(yenSymbol)) {
                    this.value = yenSymbol + this.value.replace(yenSymbol, '');
                }
            });

            priceInput.addEventListener('blur', function () {
                if (this.value === yenSymbol) {
                    this.value = '';
                }
            });
        });
    </script>
</body>
</html>
