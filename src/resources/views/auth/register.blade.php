@extends('layouts.app')

@section('title', '会員登録ページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="register-box">
    <h1 class="title">会員登録</h1>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="input-group">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
        </div>
        <div class="register-form__error-message">
            @error('email')
            {{ $message }}
            @enderror
        </div>
        <div class="input-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="register-form__error-message">
            @error('password')
            {{ $message }}
            @enderror
        </div>
        <button type="submit" class="btn">登録する</button>
    </form>
    <div class="login-link">
        <a href="{{ route('login') }}">ログインはこちら</a>
    </div>
</div>
@endsection
