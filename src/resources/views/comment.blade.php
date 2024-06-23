@extends('layouts.main')

@section('title', 'コメントページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/comment.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            <div class="icons">
                <div class="icon">
                    <i class="far fa-star"></i>
                    <span>3</span>
                </div>
                <div class="icon">
                    <i class="far fa-comment"></i>
                    <span>14</span>
                </div>
            </div>
            <div class="comment-list">
                <div class="comment-item">
                    <div class="comment-author">
                        <div class="author-avatar"></div>
                        <span class="author-name">名前</span>
                    </div>
                    <div class="comment-content"></div>
                </div>
                <div class="comment-item">
                    <div class="comment-author">
                        <div class="author-avatar"></div>
                        <span class="author-name">名前</span>
                    </div>
                    <div class="comment-content"></div>
                </div>
                <div class="comment-item">
                    <div class="comment-author right">
                        <div class="author-avatar"></div>
                        <span class="author-name">名前</span>
                    </div>
                    <div class="comment-content"></div>
                </div>
            </div>
            <form action="{{ route('item.comment.submit', ['id' => $item->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="comment">商品のコメント</label>
                    <textarea id="comment" name="comment" rows="4" required></textarea>
                </div>
                <button type="submit" class="buy-button">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection
