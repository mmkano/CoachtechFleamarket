@extends('layouts.main')

@section('title', $item->name . 'のコメント')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/comment.css') }}">
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
                        <i class="far fa-comment"></i>
                        <span>{{ $item->comments->unique('user_id')->count() }}</span>
                    </div>
                </div>
                <div class="comment-list">
                    @foreach($item->comments->unique('user_id') as $comment)
                        <div class="comment-item">
                            <div class="comment-author {{ ($loop->index + 1) % 3 == 0 ? 'reverse' : '' }}">
                                <div class="author-avatar"></div>
                                <span class="author-name">{{ $comment->user->name }}</span>
                            </div>
                            <div class="comment-content">{{ $comment->comment }}</div>
                        </div>
                    @endforeach
                </div>
                <form action="{{ route('comments.submit', ['id' => $item->id]) }}" method="POST">
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
