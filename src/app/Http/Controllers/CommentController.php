<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitCommentRequest;
use App\Models\Comment;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function showComments($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'コメントを見るにはログインしてください。');
        }

        $item = Item::findOrFail($id);
        $comments = $item->comments;
        return view('comment', compact('item', 'comments'));
    }

    public function submitComment(SubmitCommentRequest $request, $id)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $id,
            'comment' => $request->comment,
        ]);

        return redirect()->route('comments.show', ['id' => $id]);
    }

    public function deleteComment($itemId, $commentId)
    {
        $comment = Comment::where('item_id', $itemId)->where('id', $commentId)->firstOrFail();

        if (auth()->id() !== $comment->user_id && !auth()->user()->is_admin) {
            return redirect()->route('comments.show', ['id' => $itemId])->with('error', '権限がありません。');
        }

        $comment->delete();

        return redirect()->route('comments.show', ['id' => $itemId])->with('status', 'コメントを削除しました。');
    }
}