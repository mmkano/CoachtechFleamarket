<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\CategoryItem;
use App\Models\Condition;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Item::query();
        $searchTerm = $request->input('search');
        $selectedCategory = null;
        $selectedCondition = null;
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_item_id', $request->input('category'));
            $selectedCategory = CategoryItem::find($request->input('category'))->name;
        }

        if ($request->filled('condition')) {
            $query->where('condition_id', $request->input('condition'));
            $selectedCondition = Condition::find($request->input('condition'))->name;
        }

        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        $items = $query->get();

        return view('search_results', compact('items', 'searchTerm', 'selectedCategory', 'selectedCondition', 'minPrice', 'maxPrice'));
    }

    public function searchByCategory()
    {
        $categories = CategoryItem::all();
        return view('search_category', compact('categories'));
    }

    public function searchByCondition()
    {
        $conditions = Condition::all();
        return view('search_condition', compact('conditions'));
    }
}
