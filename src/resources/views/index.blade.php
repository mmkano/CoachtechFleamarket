@extends('layouts.common')

@section('title', 'トップページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="top-container">
    <div class="tabs">
        <a href="#" class="tab active">おすすめ</a>
        <a href="#" class="tab">マイリスト</a>
    </div>
    <div class="items">
        @foreach($items as $item)
            <div class="item">
                <a href="{{ route('item.show', ['id' => $item->id]) }}">
                    <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
                </a>
            </div>
        @endforeach
    </div>
    </div>
@endsection
