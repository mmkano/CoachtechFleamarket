@extends('layouts.common')

@section('title', '検索結果')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search_results.css') }}">
@endsection

@section('content')
    <div class="search-results-container">
        <h1>
            @if(isset($searchTerm) && $searchTerm)
                {{ $searchTerm }} の検索結果
            @elseif(isset($selectedCategory) && $selectedCategory)
                {{ $selectedCategory }} の検索結果
            @elseif(isset($selectedCondition) && $selectedCondition)
                {{ $selectedCondition }} の検索結果
            @elseif(isset($minPrice) && isset($maxPrice))
                ¥{{ number_format($minPrice) }} - ¥{{ number_format($maxPrice) }} の検索結果
            @elseif(isset($minPrice))
                ¥{{ number_format($minPrice) }} 以上 の検索結果
            @elseif(isset($maxPrice))
                ¥{{ number_format($maxPrice) }} 以下 の検索結果
            @else
                検索結果
            @endif
        </h1>
        <div class="items">
            @forelse($items as $item)
                <div class="item">
                    <a href="{{ route('item.show', ['id' => $item->id]) }}">
                        <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
                        <div class="price">¥{{ number_format($item->price) }}</div>
                    </a>
                    <span class="name">{{ $item->name }}</span>
                </div>
            @empty
                <p>検索結果がありません。</p>
            @endforelse
        </div>
    </div>
@endsection
