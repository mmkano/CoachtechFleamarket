@extends('layouts.common')

@section('title', 'ブランド検索')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search_brand.css') }}">
@endsection

@section('content')
<div class="search-brand-container">
            <h1>ブランド</h1>
            <input type="text" class="search-input" placeholder="ブランドをさがす">
            <a href="#" class="clear-selection">選択をクリア</a>
            <form id="brand-search-form" action="{{ route('items.search') }}" method="GET">
                <ul class="brand-list">
                    @foreach($brands as $brand)
                        <li>
                            <input type="checkbox" id="brand-{{ $brand->id }}" name="brands[]" value="{{ $brand->id }}">
                            <label for="brand-{{ $brand->id }}">{{ $brand->name }}</label>
                        </li>
                    @endforeach
                </ul>
                <button type="submit" class="search-button">商品を検索する</button>
            </form>
        </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-input');
            const brandListItems = document.querySelectorAll('.brand-list li');
            const brandSearchForm = document.getElementById('brand-search-form');

            searchInput.addEventListener('input', function() {
                const filter = searchInput.value.toLowerCase();
                brandListItems.forEach(function(item) {
                    const label = item.querySelector('label').textContent.toLowerCase();
                    if (label.includes(filter)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            document.querySelector('.clear-selection').addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.brand-list input[type="checkbox"]').forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            });
        });
</script>
@endsection