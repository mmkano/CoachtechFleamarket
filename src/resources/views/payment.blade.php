<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>支払い方法の変更</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
</head>
<body>
    <header class="header">
        <h1>支払い方法の変更</h1>
    </header>

    <main class="main">
        <div class="payment-change-container">
            <form action="{{ route('payment.update', ['id' => $item->id]) }}" method="POST">
                @csrf
                <div class="payment-method-radio">
                    <ul>
                        <li class="list_item">
                            <input type="radio" id="credit_card" class="option-input" name="payment_method" value="credit_card" {{ old('payment_method', $user->payment_method) == 'credit_card' ? 'checked' : '' }}>
                            <label for="credit_card">クレジットカード</label>
                        </li>
                        <div class="credit-card-info">
                            <div class="input-group">
                                <label for="credit_card_number">クレジットカード番号</label>
                                <input type="text" id="credit_card_number" name="credit_card_number" value="{{ old('credit_card_number', $user->credit_card_number) }}">
                            </div>
                            <div class="input-group">
                                <label for="credit_card_expiration">有効期限 (MM/YY)</label>
                                <input type="text" id="credit_card_expiration" name="credit_card_expiration" value="{{ old('credit_card_expiration', $user->credit_card_expiration) }}">
                            </div>
                            <div class="input-group">
                                <label for="credit_card_cvc">CVC</label>
                                <input type="text" id="credit_card_cvc" name="credit_card_cvc" value="{{ old('credit_card_cvc', $user->credit_card_cvc) }}">
                            </div>
                        </div>
                        <li class="list_item">
                            <input type="radio" id="bank_transfer" class="option-input" name="payment_method" value="bank_transfer" {{ old('payment_method', $user->payment_method) == 'bank_transfer' ? 'checked' : '' }}>
                            <label for="bank_transfer">銀行振込</label>
                        </li>
                        <li class="list_item">
                            <input type="radio" id="convenience_store" class="option-input" name="payment_method" value="convenience_store" {{ old('payment_method', $user->payment_method) == 'convenience_store' ? 'checked' : '' }}>
                            <label for="convenience_store">コンビニ払い</label>
                        </li>
                    </ul>
                </div>

                <button type="submit" class="submit-button">更新する</button>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const creditCardRadio = document.getElementById('credit_card');
            const bankTransferRadio = document.getElementById('bank_transfer');
            const convenienceStoreRadio = document.getElementById('convenience_store');
            const creditCardInfo = document.querySelector('.credit-card-info');

            function updateVisibility() {
                creditCardInfo.style.display = creditCardRadio.checked ? 'block' : 'none';
            }

            creditCardRadio.addEventListener('change', updateVisibility);
            bankTransferRadio.addEventListener('change', updateVisibility);
            convenienceStoreRadio.addEventListener('change', updateVisibility);

            updateVisibility(); // 初期表示を設定
        });
    </script>
</body>
</html>
