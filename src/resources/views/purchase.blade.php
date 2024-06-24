@extends('layouts.main')

@section('title', '購入ページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase-container">
        <div class="item-info">
            <div class="item__inner">
                <div class="item-image">
                <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
                </div>
                <div class="item-details">
                    <h1>{{ $item->name }}</h1>
                    <p>¥{{ number_format($item->price) }}</p>
                </div>
            </div>
            <div class="payment-info">
                <div class="payment-method">
                    <div class="payment-method__header">
                        <span>支払い方法</span>
                        <a href="#" class="change-link-payment">変更する</a>
                    </div>
                </div>
                <div class="delivery-address">
                    <div class="delivery-address__header">
                        <span>配送先</span>
                        <a href="{{ route('address', ['id' => $item->id]) }}" class="change-link-address">変更する</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-summary">
            <div class="summary__inner">
                <div class="summary-item">
                    <p class="summary-label">商品代金</p>
                    <p class="summary-value-price">¥{{ number_format($item->price) }}</p>
                </div>
                <div class="summary-item summary-item-payment">
                    <p class="summary-label">支払い金額</p>
                    <p class="summary-value-total">¥{{ number_format($item->price) }}</p>
                </div>
                <div class="summary-item">
                    <p class="summary-label">支払い方法</p>
                    <p class="summary-value-method">コンビニ払い</p>
                </div>
            </div>
            <button class="buy-button" onclick="window.location.href='{{ route('address', ['id' => $item->id]) }}'">購入する</button>
        </div>
    </div>
@endsection