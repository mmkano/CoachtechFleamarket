@extends('layouts.common')

@section('title', '検索結果')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search_results.css') }}">
@endsection

@section('content')
    <div class="results-content">
        <div class="search-sidebar">
            <div class="sidebar-header">
                <h2>絞り込み</h2>
                <a href="{{ route('items.search') }}">クリア</a>
            </div>
            <form action="{{ route('items.search') }}" method="GET" class="filter-form">
                <input type="hidden" name="category" value="{{ request('category') }}">

                <div class="filter-group">
                    <div class="filter-header" onclick="toggleFilter('search')">
                        <label for="search">キーワード</label>
                        <span class="arrow">▼</span>
                    </div>
                    <div class="filter-body" id="search" style="display:none;">
                        <input type="text" name="search" id="search" value="{{ request('search') }}">
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-header" onclick="toggleFilter('category')">
                        <label for="category">カテゴリー</label>
                        <span class="arrow">▼</span>
                    </div>
                    <div class="filter-body" id="category" style="display:none;">
                        <select name="category" id="category-select">
                            <option value="">すべて</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-header" onclick="toggleFilter('brands')">
                        <label for="brands">ブランド</label>
                        <span class="arrow">▼</span>
                    </div>
                    <div class="filter-body" id="brands" style="display:none;">
                        <select name="brands[]" id="brands-select" multiple>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ in_array($brand->id, request('brands', [])) ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-header" onclick="toggleFilter('condition')">
                        <label for="condition">商品状態</label>
                        <span class="arrow">▼</span>
                    </div>
                    <div class="filter-body" id="condition" style="display:none;">
                        <select name="condition" id="condition-select">
                            <option value="">選択してください</option>
                            @foreach($conditions as $condition)
                                <option value="{{ $condition->id }}" {{ request('condition') == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="filter-group">
                    <div class="filter-header" onclick="toggleFilter('price')">
                        <label for="price">価格</label>
                        <span class="arrow">▼</span>
                    </div>
                    <div class="filter-body" id="price" style="display:none;">
                        <label for="min_price">最低価格</label>
                        <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}">
                        <label for="max_price">最高価格</label>
                        <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}">
                    </div>
                </div>

                <button type="submit" class="filter-button">再検索</button>
            </form>
        </div>
        <div class="search-results-container">
            <h1>
                @if(isset($searchTerm) && $searchTerm)
                    {{ $searchTerm }} の検索結果
                @elseif(isset($selectedCategory) && $selectedCategory)
                    {{ $selectedCategory }} の検索結果
                @elseif(isset($selectedCondition) && $selectedCondition)
                    {{ $selectedCondition }} の検索結果
                @elseif(isset($selectedBrands) && count($selectedBrands) > 0)
                    @php
                        $brandNames = \App\Models\Brand::whereIn('id', $selectedBrands)->pluck('name')->implode(', ');
                    @endphp
                    {{ $brandNames }} の検索結果
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
                            <img src="{{ $item->img_url }}" alt="{{ $item->name }}">
                            <div class="price">¥{{ number_format($item->price) }}</div>
                        </a>
                        <span class="name">{{ $item->name }}</span>
                    </div>
                @empty
                    <p>検索結果がありません。</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function toggleFilter(id) {
            var filterBody = document.getElementById(id);
            var arrow = filterBody.previousElementSibling.querySelector('.arrow');
            if (filterBody.style.display === "none") {
                filterBody.style.display = "block";
                arrow.textContent = "▲";
            } else {
                filterBody.style.display = "none";
                arrow.textContent = "▼";
            }
        }
    </script>
@endsection
