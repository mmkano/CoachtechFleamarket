@extends('layouts.app')

@section('title', 'ログインページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login-box">
    <h1 class="title">ログイン</h1>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="input-group">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
        </div>
        <div class="login-form__error-message">
            @error('email')
            {{ $message }}
            @enderror
        </div>
        <div class="input-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="login-form__error-message">
            @error('password')
            {{ $message }}
            @enderror
        </div>
        <button type="submit" class="btn">ログインする</button>
    </form>
    <div class="register-link">
        <a href="{{ route('register') }}">会員登録はこちら</a>
    </div>
</div>
@endsection

