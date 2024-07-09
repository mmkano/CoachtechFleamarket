@extends('layouts.main')

@section('title', 'プロフィール設定')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit-profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('content')
    <div class="profile-edit-container">
        <h1>プロフィール設定</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
            @csrf
            <div class="profile-image-section">
                <div class="profile-image">
                    @if(Auth::user()->profile_image)
                        <img id="profileImagePreview" src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="ユーザー画像">
                    @else
                        <img id="profileImagePreview" src="{{ asset('images/default.png') }}" alt="ユーザー画像">
                    @endif
                </div>
                <div class="file-input-container">
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" class="file-input">
                    <label for="profile_image" class="file-input-label">画像を選択する</label>
                </div>
            </div>
            <div class="input-group">
                <label for="name">ユーザー名</label>
                <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}">
            </div>
            <div class="input-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}">
            </div>
            <div class="input-group">
                <label for="address">住所</label>
                <input type="text" id="address" name="address" value="{{ old('address', Auth::user()->address) }}">
            </div>
            <div class="input-group">
                <label for="building_name">建物名</label>
                <input type="text" id="building_name" name="building_name" value="{{ old('building_name', Auth::user()->building_name) }}">
            </div>
            <h2 class="toggle-section" data-target="#creditCardInfo">クレジットカード情報 <i class="fas fa-chevron-down"></i></h2>
            <div id="creditCardInfo" class="toggle-content">
                <div class="input-group">
                    <label for="credit_card_number">カード番号</label>
                    <input type="text" id="credit_card_number" name="credit_card_number" value="{{ old('credit_card_number', Auth::user()->credit_card_number) }}">
                </div>
                <div class="input-group">
                    <label for="credit_card_expiration">有効期限 (YY/MM)</label>
                    <input type="text" id="credit_card_expiration" name="credit_card_expiration" value="{{ old('credit_card_expiration', Auth::user()->credit_card_expiration) }}">
                </div>
                <div class="input-group">
                    <label for="credit_card_cvc">CVC</label>
                    <input type="text" id="credit_card_cvc" name="credit_card_cvc" value="{{ old('credit_card_cvc', Auth::user()->credit_card_cvc) }}">
                </div>
                <div id="card-element"></div>
            </div>
            <h2 class="toggle-section" data-target="#bankInfo">銀行情報 <i class="fas fa-chevron-down"></i></h2>
            <div id="bankInfo" class="toggle-content">
                <div class="input-group">
                    <label for="bank_account_number">銀行口座番号</label>
                    <input type="text" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', Auth::user()->bank_account_number) }}">
                </div>
                <div class="input-group">
                    <label for="bank_branch_name">支店名</label>
                    <input type="text" id="bank_branch_name" name="bank_branch_name" value="{{ old('bank_branch_name', Auth::user()->bank_branch_name) }}">
                </div>
                <div class="input-group">
                    <label for="bank_branch_code">支店コード</label>
                    <input type="text" id="bank_branch_code" name="bank_branch_code" value="{{ old('bank_branch_code', Auth::user()->bank_branch_code) }}">
                </div>
                <div class="input-group">
                    <label for="bank_name">銀行名</label>
                    <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', Auth::user()->bank_name) }}">
                </div>
                <div class="input-group">
                    <label for="bank_account_type">口座種別</label>
                    <input type="text" id="bank_account_type" name="bank_account_type" value="{{ old('bank_account_type', Auth::user()->bank_account_type) }}">
                </div>
                <div class="input-group">
                    <label for="bank_account_holder">口座名義人</label>
                    <input type="text" id="bank_account_holder" name="bank_account_holder" value="{{ old('bank_account_holder', Auth::user()->bank_account_holder) }}">
                </div>
            </div>
            <button type="submit" class="submit-button">更新する</button>
        </form>
    </div>
@endsection

@section('scripts')
<script>
        document.addEventListener('DOMContentLoaded', function() {
        const profileImageInput = document.getElementById('profile_image');
        const profileImagePreview = document.getElementById('profileImagePreview');

        profileImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImagePreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        const toggleSections = document.querySelectorAll('.toggle-section');
        toggleSections.forEach(section => {
            section.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                const icon = this.querySelector('i');
                target.classList.toggle('active');
                icon.classList.toggle('fa-times');
            });
        });
    });
    </script>
@endsection
