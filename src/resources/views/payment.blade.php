<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>支払い方法の変更</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
</head>
<body>
    <header class="header">
    </header>

    <main class="main">
        <div class="container">
            <h2 class="title">お支払い方法</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('payment.update', ['id' => $item->id]) }}" method="POST" id="payment-form">
                @csrf
                <input type="hidden" id="amount" name="amount" value="1000">
                <div class="form-group">
                    <div class="payment-options">
                        <div class="payment-option">
                            <input type="radio" id="credit_card" name="payment_method" value="credit_card" {{ $item->payment_method == 'credit_card' ? 'checked' : '' }}>
                            <label for="credit_card">クレジットカード</label>
                        </div>
                        <div id="card-details" class="card-details" style="display: none;">
                    <div class="form-group">
                        <label for="card-number" class="card-label">カード番号</label>
                        <div id="card-number" class="form-control"></div>
                    </div>
                    <div class="form-group">
                        <label for="card-expiry" class="card-label">有効期限</label>
                        <div id="card-expiry" class="form-control"></div>
                    </div>
                    <div class="form-group">
                        <label for="card-cvc" class="card-label">セキュリティコード</label>
                        <div id="card-cvc" class="form-control"></div>
                    </div>
                    <div id="card-errors" class="card-errors" role="alert"></div>
                </div>
                        <div class="payment-option">
                            <input type="radio" id="convenience_store" name="payment_method" value="convenience_store" {{ $item->payment_method == 'convenience_store' ? 'checked' : '' }}>
                            <label for="convenience_store">コンビニ</label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" {{ $item->payment_method == 'bank_transfer' ? 'checked' : '' }}>
                            <label for="bank_transfer">銀行振込</label>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="payment_method_id" id="payment-method-id">
                <button type="submit" class="btn btn-primary">支払いを送信</button>
            </form>
        </div>
    </main>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var stripe = Stripe('{{ env("STRIPE_KEY") }}');
            var elements = stripe.elements();

            var style = {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            var cardNumberElement = elements.create('cardNumber', { style: style });
            var cardExpiryElement = elements.create('cardExpiry', { style: style });
            var cardCvcElement = elements.create('cardCvc', { style: style });

            cardNumberElement.mount('#card-number');
            cardExpiryElement.mount('#card-expiry');
            cardCvcElement.mount('#card-cvc');

            var form = document.getElementById('payment-form');
            var cardDetails = document.getElementById('card-details');

            document.querySelectorAll('input[name="payment_method"]').forEach(function(el) {
                el.addEventListener('change', function(event) {
                    if (event.target.value === 'credit_card') {
                        cardDetails.style.display = 'block';
                    } else {
                        cardDetails.style.display = 'none';
                    }
                });
            });

            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                if (!paymentMethod) {
                    document.getElementById('card-errors').textContent = '支払い方法を選択してください。';
                    return;
                }

                if (paymentMethod.value === 'credit_card') {
                    const name = "{{ $user->name }}";
                    const { paymentMethod: stripePaymentMethod, error } = await stripe.createPaymentMethod(
                        'card', cardNumberElement, {
                            billing_details: { name: name }
                        }
                    );

                    if (error) {
                        console.error('Error creating payment method:', error.message);
                        document.getElementById('card-errors').textContent = error.message;
                    } else {
                        console.log('Payment method created:', stripePaymentMethod.id);
                        document.getElementById('payment-method-id').value = stripePaymentMethod.id;

                        const response = await fetch("{{ route('payment.update', ['id' => $item->id]) }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                amount: document.getElementById('amount').value,
                                payment_method: 'credit_card',
                                payment_method_id: stripePaymentMethod.id
                            })
                        });

                        const paymentIntent = await response.json();

                        if (paymentIntent.error) {
                            console.error('Error confirming payment:', paymentIntent.error);
                            document.getElementById('card-errors').textContent = paymentIntent.error;
                        } else {
                            console.log('Payment intent confirmed:', paymentIntent.client_secret);
                            const result = await stripe.confirmCardPayment(paymentIntent.client_secret);

                            if (result.error) {
                                console.error('Error confirming card payment:', result.error.message);
                                document.getElementById('card-errors').textContent = result.error.message;
                            } else {
                                if (result.paymentIntent.status === 'succeeded') {
                                    console.log('Payment succeeded:', result.paymentIntent.id);
                                    window.location.href = "{{ route('item.purchase', ['id' => $item->id]) }}";
                                }
                            }
                        }
                    }
                } else {
                    // 銀行振込やコンビニ払いの場合
                    const response = await fetch("{{ route('payment.update', ['id' => $item->id]) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            amount: document.getElementById('amount').value,
                            payment_method: paymentMethod.value
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        window.location.href = "{{ route('item.purchase', ['id' => $item->id]) }}";
                    } else {
                        console.error('Error completing payment:', result.error);
                    }
                }
            });
        });
    </script>
</body>
</html>
