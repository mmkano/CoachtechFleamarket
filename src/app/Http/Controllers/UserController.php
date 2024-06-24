<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();
        $items = Item::where('user_id', $user->id)->get();
        return view('mypage', compact('user', 'items'));
    }
}
