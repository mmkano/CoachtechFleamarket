@extends('layouts.common')

@section('title', '商品状態検索')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search_condition.css') }}">
@endsection

@section('content')
    <div class="search-container">
        <h2>商品状態</h2>
        <ul class="search-list">
            @foreach($conditions as $condition)
                <li>
                    <a href="{{ route('items.search', ['condition' => $condition->id]) }}">
                        {{ $condition->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
