<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品の出品</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
</head>
<body>
    <header class="header">
    </header>

    <main>
        <div class="create-item-container">
            <h1>商品の出品</h1>
            <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data" onsubmit="removeYenSymbol()">
                @csrf
                <div class="input-group">
                    <label for="img_url">商品画像</label>
                    <div id="preview-container"></div>
                    <div class="file-input-container">
                        <input type="file" id="img_url" name="img_url" accept="image/*" class="file-input">
                        <label for="img_url" class="file-input-label">画像を選択する</label>
                    </div>
                </div>
                <div class="ttl">
                    <h2>商品の詳細</h2>
                </div>
                <div class="input-group">
                    <label for="category_item_id">カテゴリー</label>
                    <select id="category_item_id" name="category_item_id">
                        <option value="" disabled selected>選択してください</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <label for="condition_id">商品の状態</label>
                    <select id="condition_id" name="condition_id">
                        <option value="" disabled selected>選択してください</option>
                        <option value="1">新品、未使用</option>
                        <option value="2">未使用に近い</option>
                        <option value="3">目立った傷や汚れなし</option>
                        <option value="4">やや傷や汚れあり</option>
                        <option value="5">傷や汚れあり</option>
                        <option value="6">全体的に状態が悪い</option>
                    </select>
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
                    <textarea id="description" name="description" class="description-textarea" placeholder="色、素材、重さ、定価、注意点など&#10;&#10;例) 2010年頃に1万円で購入したジャケットです。ライトグレーで傷はありません。あわせやすいのでおすすめです。&#10;&#10;#ジャケット #ジャケットコーデ"></textarea>
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
                priceInput.value = yenSymbol + priceInput.value;
            }

            priceInput.addEventListener('input', function () {
                let currentValue = this.value.replace(/[^\d]/g, '');
                this.value = yenSymbol + currentValue;
            });

            priceInput.addEventListener('blur', function () {
                if (this.value === yenSymbol) {
                    this.value = '';
                }
            });

            const imgInput = document.getElementById('img_url');
            const previewContainer = document.getElementById('preview-container');

            imgInput.addEventListener('change', function() {
                const files = this.files;

                if (files && files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('preview-image');
                        previewContainer.innerHTML = '';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });
        });

        function removeYenSymbol() {
            const priceInput = document.getElementById('price');
            priceInput.value = priceInput.value.replace('¥', '');
        }
    </script>
</body>
</html>
