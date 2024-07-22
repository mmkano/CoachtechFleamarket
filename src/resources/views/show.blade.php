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
                <img src="{{ Storage::disk('s3')->url($item->img_url) }}" alt="{{ $item->name }}">
            </div>
            <div class="item-info">
                <h1>{{ $item->name }}</h1>
                <span>{{ $item->brand ? $item->brand->name : '' }}</span>
                <p class="price">¥{{ number_format($item->price) }}(値段)</p>
                <div class="icons">
                    <div class="icon">
                        <form class="star-form" action="{{ route('favorite.toggle', ['item' => $item->id]) }}" method="POST">
                            @csrf
                            @auth
                                @if(Auth::user()->favorites->contains('item_id', $item->id))
                                    @method('DELETE')
                                    <button type="submit" class="favorite-button">
                                        <i class="fas fa-star"></i>
                                    </button>
                                @else
                                    <button type="submit" class="favorite-button">
                                        <i class="far fa-star"></i>
                                    </button>
                                @endif
                            @else
                            <a href="{{ route('login') }}">
                                <i class="far fa-star"></i>
                            </a>
                            @endauth
                            <span class="icon-count">{{ $item->favorites->count() }}</span>
                        </form>
                    </div>
                    <div class="icon">
                        <a href="{{ route('comments.show', ['id' => $item->id]) }}"><i class="far fa-comment"></i></a>
                        <span class="icon-count">{{ $item->comments->count() }}</span>
                    </div>
                </div>
                @auth
                    <button class="buy-button" onclick="window.location.href='{{ route('item.purchase', ['id' => $item->id]) }}'">購入する</button>
                @else
                    <button class="buy-button" onclick="window.location.href='{{ route('login') }}'">購入する</button>
                @endauth
                <h2 class="item-description-title">商品説明</h2>
                <p class="item-description">{{ $item->description }}</p>
                <h2 class="item-info-title">商品の情報</h2>
                <p class="item-category">カテゴリー <span id="selected-category">{{ $item->categoryItem->name }}</span></p>
                <p class="item-condition">商品の状態 <span id="selected-condition">{{ $item->condition->name }}</span></p>
            </div>
        </div>
    </div>
@endsection
