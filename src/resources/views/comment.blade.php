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
            <img src="{{ $item->img_url }}" alt="{{ $item->name }}">
        </div>
        <div class="item-info">
            <h1>{{ $item->name }}</h1>
            <span>ブランド名</span>
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
                        <i class="far fa-star"></i>
                        @endauth
                        <span class="icon-count">{{ $item->favorites->count() }}</span>
                    </form>
                </div>
                <div class="icon">
                    <a href="{{ route('comments.show', ['id' => $item->id]) }}"><i class="far fa-comment"></i></a>
                    <span class="icon-count">{{ $item->comments->count() }}</span>
                </div>
            </div>
            <div class="comment-list">
                @foreach($item->comments as $comment)
                <div class="comment-item">
                    <div class="comment-author {{ ($loop->index + 1) % 3 == 0 ? 'reverse' : '' }}">
                        <div class="author-avatar">
                            @if($comment->user->profile_image)
                            <img src="{{ $comment->user->profile_image }}" alt="ユーザー画像">
                            @else
                            <img src="{{ asset('images/default.png') }}" alt="ユーザー画像">
                            @endif
                        </div>
                        <span class="author-name">{{ $comment->user->name }}</span>
                    </div>
                    <div class="comment-content">{{ $comment->comment }}
                        <div class="comment-date">{{ $comment->created_at->format('Y/m/d H:i:s') }}</div>
                        @if(auth()->id() === $comment->user_id || auth()->user()->is_admin)
                        <button class="delete-button" onclick="confirmDelete({{ $item->id }}, {{ $comment->id }})">
                            <i class="far fa-trash-alt"></i>
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <form action="{{ route('comments.submit', ['id' => $item->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="comment">商品のコメント</label>
                    <textarea id="comment" name="comment" rows="4"></textarea>
                </div>
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
                <button type="submit" class="buy-button">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>

<!-- モーダルダイアログ -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
        <h1>コメントの削除</h1>
        <p>本当にこのコメントを削除してよろしいですか？</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-buttons">
                <button type="submit" class="confirm-delete-button">削除する</button>
                <button type="button" class="cancel-button" onclick="closeModal()">キャンセル</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(itemId, commentId) {
        const form = document.getElementById('deleteForm');
        form.action = `/item/${itemId}/comments/${commentId}`;
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }
</script>
@endsection
