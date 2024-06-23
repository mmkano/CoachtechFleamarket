<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\CategoryItem;
use App\Models\Condition;

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
        return view('create');
    }

    public function showComments($id)
    {
        $item = Item::findOrFail($id);
        return view('comment', compact('item'));
    }

    public function submitComment(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        return redirect()->route('item.comments', ['id' => $id]);
    }

}
