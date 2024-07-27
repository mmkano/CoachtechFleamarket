<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryItem;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Item::query();
        $searchTerm = $request->input('search');
        $selectedCategory = $request->input('category');
        $selectedCondition = $request->input('condition');
        $selectedBrands = $request->input('brands', []);
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        if ($searchTerm) {
            $query->where(function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        if ($selectedCategory) {
            $query->where('category_item_id', $selectedCategory);
            $selectedCategory = CategoryItem::find($selectedCategory)->name;
        }

        if ($selectedCondition) {
            $query->where('condition_id', $selectedCondition);
            $selectedCondition = Condition::find($selectedCondition)->name;
        }

        if (!empty($selectedBrands)) {
            $query->whereIn('brand_id', $selectedBrands);
        }

        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        $items = $query->get();
        $categories = CategoryItem::all();
        $conditions = Condition::all();
        $brands = Brand::all();

        return view('search_results', compact('items', 'searchTerm', 'selectedCategory', 'selectedCondition', 'selectedBrands', 'minPrice', 'maxPrice', 'categories', 'conditions', 'brands'));
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

    public function searchByBrand()
    {
        $brands = Brand::all();
        return view('search_brand', compact('brands'));
    }
}
