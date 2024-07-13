<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('comments')->findOrFail($id);
        return view('admin.user_detail', compact('user'));
    }

    public function deleteUser($id)
    {
        Log::info("Attempting to delete user with ID: $id");
        $user = User::findOrFail($id);
        $user->delete();
        Log::info("User with ID: $id deleted successfully");
        return redirect()->route('admin.users')->with('success', 'ユーザーが削除されました。');
    }

    public function deleteComment($id)
    {
        Log::info("Deleting comment with ID: $id");
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'コメントが削除されました。');
    }

    public function sendEmail(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        Mail::to($user->email)->send(new AdminNotificationMail($request->subject, $request->message));
        return redirect()->back()->with('success', 'メールが送信されました。');
    }
}
