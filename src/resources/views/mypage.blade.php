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
                <img src="{{ asset('images/default.png') }}" alt="ユーザー画像">
            </div>
            <div class="profile-name">
                <h2>ユーザー名</h2>
            </div>
            </div>
            <button class="edit-profile-button">プロフィールを編集</button>
        </div>

        <div class="tabs">
            <a href="#" class="tab active">出品した商品</a>
            <a href="#" class="tab">購入した商品</a>
        </div>

        <div class="items">
            <div class="item">
                <img src="{{ asset('images/default.png') }}" alt="商品画像">
            </div>
            <div class="item">
                <img src="{{ asset('images/default.png') }}" alt="商品画像">
            </div>
            <div class="item">
                <img src="{{ asset('images/default.png') }}" alt="商品画像">
            </div>
            <div class="item">
                <img src="{{ asset('images/default.png') }}" alt="商品画像">
            </div>
            <div class="item">
                <img src="{{ asset('images/default.png') }}" alt="商品画像">
            </div>
            <div class="item">
                <img src="{{ asset('images/default.png') }}" alt="商品画像">
            </div>
            <div class="item">
                <img src="{{ asset('images/default.png') }}" alt="商品画像">
            </div>
            <div class="item">
                <img src="{{ asset('images/default.png') }}" alt="商品画像">
            </div>
        </div>
    </div>
@endsection
