@extends('layouts.common')

@section('title', 'カテゴリー検索')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search_category.css') }}">
@endsection

@section('content')
    <div class="category-container">
        <div class="category-header">カテゴリー</div>
        <ul class="category-list">
            @foreach($categories as $category)
                <li class="category-item">
                    <a href="{{ route('items.search', ['category' => $category->id]) }}" class="category-link">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
