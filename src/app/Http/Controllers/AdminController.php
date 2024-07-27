<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailRequest;
use App\Mail\AdminNotificationMail;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

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
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'ユーザーが削除されました。');
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'コメントが削除されました。');
    }

    public function sendEmail(SendEmailRequest $request, $id)
    {
        $user = User::findOrFail($id);
        Mail::to($user->email)->send(new AdminNotificationMail($request->subject, $request->message));
        return redirect()->back()->with('success', 'メールが送信されました。');
    }
}
