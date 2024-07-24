@extends('layouts.admin')

@section('title', $user->name . 'さんの詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/user_detail.css') }}">
@endsection

@section('content')
    <div class="user-detail-container">
        <div class="user-info">
            <h2>{{ $user->name }}</h2>
            <div class="actions">
                <button class="btn btn-danger" onclick="confirmDeleteUser({{ $user->id }})">ユーザー削除</button>
                <button class="btn btn-primary" id="sendEmailButton">メール送信</button>
            </div>
        </div>

        <div class="comments-section">
            <h3>コメント一覧</h3>
            @forelse($user->comments as $comment)
                <div class="comment-item">
                    <div class="comment-details">
                        <p>{{ $comment->comment }}</p>
                        <p class="comment-date">{{ $comment->created_at->format('Y/m/d H:i:s') }}</p>
                    </div>
                    <button class="btn btn-danger" onclick="confirmDeleteComment({{ $comment->id }})">削除</button>
                </div>
            @empty
                <p>コメントがありません。</p>
            @endforelse
        </div>
    </div>

    <div id="emailModal" class="modal" @if ($errors->any()) style="display: block;" @endif>
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>メール送信</h2>
            <form action="{{ route('admin.users.send-email', $user->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="subject">To</label>
                    <p>{{ $user->email }}</p>
                </div>
                <div class="form-group">
                    <label for="subject">件名</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}">
                </div>
                <div class="form-group">
                    <label for="message">本文</label>
                    <textarea id="message" name="message" rows="4">{{ old('message') }}</textarea>
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
                <button type="submit" class="btn btn-primary">送信</button>
            </form>
        </div>
    </div>

    <!-- モーダルダイアログ -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">&times;</span>
            <h1>削除確認</h1>
            <p>本当にこの操作を実行してよろしいですか？</p>
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
        function confirmDeleteUser(userId) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/users/${userId}`;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function confirmDeleteComment(commentId) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/comments/${commentId}`;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const emailModal = document.getElementById('emailModal');
            const sendEmailButton = document.getElementById('sendEmailButton');
            const closeModal = document.querySelector('.modal .close');

            sendEmailButton.addEventListener('click', function() {
                emailModal.style.display = 'block';
            });

            closeModal.addEventListener('click', function() {
                emailModal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target == emailModal) {
                    emailModal.style.display = 'none';
                }
            });
        });
    </script>
@endsection