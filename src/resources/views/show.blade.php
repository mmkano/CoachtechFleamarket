@extends('layouts.common')

@section('title', $item->name . 'の詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('content')
<div class="info-container">
    <div class="item-detail">
        <div class="item-image">
            <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
        </div>
        <div class="item-info">
            <h1>{{ $item->name }}</h1>
            <span>ブランド名</span>
            <p class="price">¥{{ number_format($item->price) }}(値段)</p>
            <div class="icons">
                <div class="icon">
                    <i class="far fa-star"></i>
                    <span>3</span>
                </div>
                <div class="icon">
                    <a href="{{ route('item.comments', ['id' => $item->id]) }}"><i class="far fa-comment"></i></a>
                    <span>14</span>
                </div>
            </div>
            <button class="buy-button" onclick="window.location.href='{{ route('item.purchase', ['id' => $item->id]) }}'">購入する</button>
            <h2>商品説明</h2>
            <p>{{ $item->description }}</p>
            <h2>商品の情報</h2>
            <p>カテゴリー: <span id="selected-category">{{ $item->categoryItem->name }}</span></p>
            <p>商品の状態: <span id="selected-condition">{{ $item->condition->name }}</span></p>
        </div>
    </div>
</div>
@endsection
