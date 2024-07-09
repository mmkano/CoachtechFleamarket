@extends('layouts.main')

@section('title', 'マイページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage-container">
        <div class="profile-section">
            <div class="profile__inner">
                <div class="profile-image">
                    @if(Auth::user()->profile_image)
                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="ユーザー画像">
                    @else
                        <img src="{{ asset('images/default.png') }}" alt="ユーザー画像">
                    @endif
                </div>
                <div class="profile-name">
                    <h2>{{ $user->name ?? $user->email }}</h2>
                </div>
            </div>
            <button class="edit-profile-button" onclick="location.href='{{ route('profile.edit') }}'">プロフィールを編集</button>
        </div>
        <div class="tabs">
            <a href="#" class="tab active" data-tab="sold-items">出品した商品</a>
            <a href="#" class="tab" data-tab="purchased-items">購入した商品</a>
        </div>
        <div id="sold-items" class="items tab-content active">
            @foreach($items as $item)
                <div class="item">
                    <a href="{{ route('item.show', ['id' => $item->id]) }}">
                        <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
                    </a>
                </div>
            @endforeach
        </div>
        <div id="purchased-items" class="items tab-content">
            @foreach($soldItems as $soldItem)
                <div class="item">
                    <img src="{{ asset('storage/' . $soldItem->item->img_url) }}" alt="{{ $soldItem->item->name }}">
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab');
            const soldItemsContent = document.querySelector('#sold-items');
            const purchasedItemsContent = document.querySelector('#purchased-items');

            soldItemsContent.style.display = 'grid';
            purchasedItemsContent.style.display = 'none';

            tabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = tab.getAttribute('data-tab');

                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    if (target === 'purchased-items') {
                        soldItemsContent.style.display = 'none';
                        purchasedItemsContent.style.display = 'grid';
                    } else {
                        soldItemsContent.style.display = 'grid';
                        purchasedItemsContent.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
