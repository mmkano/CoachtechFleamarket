@extends('layouts.common')

@section('title', '住所の変更')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
    <div class="address-container">
        <h1>住所の変更</h1>
        <form action="{{ route('address.update') }}" method="POST">
            @csrf
            <div class="input-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" id="postal_code" name="postal_code">
            </div>
            <div class="input-group">
                <label for="address">住所</label>
                <input type="text" id="address" name="address">
            </div>
            <div class="input-group">
                <label for="building_name">建物名</label>
                <input type="text" id="building_name" name="building_name">
            </div>
            <button type="submit" class="update-button">更新する</button>
        </form>
    </div>
@endsection
