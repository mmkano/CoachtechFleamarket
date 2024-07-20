<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\SoldItem;

class UserController extends Controller
{
    public function myPage()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'このページにアクセスするにはログインが必要です。');
        }

        $user = Auth::user();
        $items = Item::where('user_id', $user->id)->get();
        $soldItems = SoldItem::where('user_id', $user->id)->get();

        return view('mypage', compact('user', 'items', 'soldItems'));
    }
}
