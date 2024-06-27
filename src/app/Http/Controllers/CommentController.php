<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function showComments($id)
    {
        $item = Item::findOrFail($id);
        $comments = $item->comments;
        return view('comment', compact('item', 'comments'));
    }

    public function submitComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $id,
            'comment' => $request->comment,
        ]);

        return redirect()->route('comments.show', ['id' => $id]);
    }
}