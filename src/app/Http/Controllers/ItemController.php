<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\CategoryItem;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('index', ['items' => $items]);
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('show', ['item' => $item]);
    }

    public function purchase($id)
    {
        $item = Item::findOrFail($id);
        return view('purchase', ['item' => $item]);
    }

    public function address()
    {
        return view('address');
    }

    public function create()
    {
        $categories = CategoryItem::all();
        $conditions = Condition::all();
        return view('create', compact('categories', 'conditions'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        $input = $request->all();
        $input['price'] = str_replace('¥', '', $input['price']);

        $request->merge($input);
        $request->validate([
            'img_url' => 'required|image',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category_item_id' => 'required|integer',
            'condition_id' => 'required|integer',
        ]);

        $path = $request->file('img_url')->store('images', 'public');

        $item = new Item();
        $item->name = $request->name;
        $item->price = $input['price'];
        $item->description = $request->description;
        $item->img_url = $path;
        $item->user_id = Auth::id();
        $item->category_item_id = $request->category_item_id;
        $item->condition_id = $request->condition_id;
        $item->save();

        return redirect()->route('home')->with('status', '商品を出品しました。');
    }
}
