<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggleFavorite(Item $item)
    {
        $user = Auth::user();
        $favorite = $user->favorites()->where('item_id', $item->id)->first();

        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('status', 'お気に入りを解除しました。');
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
            return redirect()->back()->with('status', 'お気に入りに追加しました。');
        }
    }

    public function destroy(Item $item)
    {
        $favorite = Auth::user()->favorites()->where('item_id', $item->id)->firstOrFail();
        $favorite->delete();

        return redirect()->back()->with('status', 'お気に入りを解除しました。');
    }

}
