@extends('layouts.main')

@section('title', 'プロフィール設定')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit-profile.css') }}">
@endsection

@section('content')
    <div class="profile-edit-container">
        <h1>プロフィール設定</h1>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="profile-image-section">
                <div class="profile-image">
                    <img src="{{ asset('images/default.png') }}" alt="ユーザー画像">
                </div>
                <div class="file-input-container">
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" class="file-input">
                    <label for="profile_image" class="file-input-label">画像を選択する</label>
                </div>
            </div>
            <div class="input-group">
                <label for="name">ユーザー名</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>
            <div class="input-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
            </div>
            <div class="input-group">
                <label for="address">住所</label>
                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
            </div>
            <div class="input-group">
                <label for="building_name">建物名</label>
                <input type="text" id="building_name" name="building_name" value="{{ old('building_name', $user->building_name) }}">
            </div>
            <button type="submit" class="submit-button">更新する</button>
        </form>
    </div>
@endsection
