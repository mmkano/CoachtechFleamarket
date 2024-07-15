@extends('layouts.common')

@section('title', 'トップページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="top-container">
        <div class="tabs">
            <a href="#" class="tab active" data-tab="recommendations">おすすめ</a>
            <a href="#" class="tab" data-tab="mylist">マイリスト</a>
        </div>
        <div class="items">
            @foreach($items as $item)
                <div id="recommendations" class="item tab-content active">
                    <a href="{{ route('item.show', ['id' => $item->id]) }}">
                        <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
                        <div class="price">¥{{ number_format($item->price) }}</div>
                    </a>
                    <span class="name">{{ $item->name }}</span>
                </div>
            @endforeach
        </div>
        <div id="mylist" class="object tab-content">
            @auth
                @forelse(Auth::user()->favorites as $favorite)
                    <div class="item">
                        <a href="{{ route('item.show', ['id' => $favorite->item->id]) }}">
                            <img src="{{ asset('storage/' . $favorite->item->img_url) }}" alt="{{ $favorite->item->name }}">
                            <div class="price">¥{{ number_format($favorite->item->price) }}</div>
                        </a>
                        <div class="name">{{ $favorite->item->name }}</div>
                    </div>
                @empty
                    <p class="no-favorites">まだお気に入りはありません。</p>
                @endforelse
            @else
                <p class="login-prompt">お気に入り機能を使用するには、<a href="{{ route('login') }}">ログイン</a>してください。</p>
            @endauth
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab');
            const itemsContent = document.querySelector('.items');
            const mylistContent = document.querySelector('.object');

            itemsContent.style.display = 'grid';
            mylistContent.style.display = 'none';

            tabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = tab.getAttribute('data-tab');

                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    if (target === 'mylist') {
                        itemsContent.style.display = 'none';
                        mylistContent.style.display = 'grid';
                    } else {
                        itemsContent.style.display = 'grid';
                        mylistContent.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
