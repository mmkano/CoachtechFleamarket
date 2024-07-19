<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>住所変更ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
</head>
<body>
    <header class="header">
    </header>

    <main>
        <div class="address-container">
            <h1>住所の変更</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('address.update', ['id' => $item->id]) }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="postal_code">郵便番号</label>
                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}">
                </div>
                <div class="input-group">
                    <label for="address">住所</label>
                    <input type="text" id="address" name="address" value="{{ old('address', Auth::user()->address) }}">
                </div>
                <div class="input-group">
                    <label for="building_name">建物名</label>
                    <input type="text" id="building_name" name="building_name" value="{{ old('building_name', Auth::user()->building_name) }}">
                </div>
                <button type="submit" class="update-button">更新する</button>
            </form>
        </div>
    </main>
</body>
</html>
