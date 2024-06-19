@extends('layouts.common')

@section('title', $item->name. 'の詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="info-container">
<div class="item-detail">
        <div class="item-image">
            <img src="{{ asset($item->img_url) }}" alt="{{ $item->name }}">
        </div>
        <div class="item-info">
            <h1>{{ $item->name }}</h1>
            <span>ブランド名</span>
            <p class="price">¥{{ number_format($item->price) }}(値段)</p>
            <button class="buy-button">購入する</button>
            <h2>商品説明</h2>
            <p>{{ $item->description }}</p>
            <h2>商品の情報</h2>
            <p>カテゴリー<span id="selected-category"> {{ $item->categoryItem->name }}</p>
            <p>商品の状態 <span id="selected-condition">{{ $item->condition->name }}</p>
        </div>
    </div>
</div>
@endsection
