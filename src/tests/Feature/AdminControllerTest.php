<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotificationMail;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->create();
        $users = User::factory()->count(3)->create();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.users'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.users');
        $response->assertViewHas('users', function ($viewUsers) use ($users) {
            return $viewUsers->pluck('id')->sort()->values()->all() === $users->pluck('id')->sort()->values()->all();
        });
    }

    public function test_show()
    {
        $admin = Admin::factory()->create();
        $user = User::factory()->create();
        $comments = Comment::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.users.show', $user->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.user_detail');
        $response->assertViewHas('user', function ($viewUser) use ($user) {
            return $viewUser->id === $user->id;
        });
    }

    public function test_delete_user()
    {
        $admin = Admin::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.users.delete', $user->id));

        $response->assertRedirect(route('admin.users'));
        $response->assertSessionHas('success', 'ユーザーが削除されました。');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_delete_comment()
    {
        $admin = Admin::factory()->create();
        $comment = Comment::factory()->create();

        $response = $this->actingAs($admin, 'admin')->delete(route('admin.comments.delete', $comment->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'コメントが削除されました。');
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_send_email()
    {
        Mail::fake();

        $admin = Admin::factory()->create();
        $user = User::factory()->create();

        $emailData = [
            'subject' => 'Test Subject',
            'message' => 'Test Message',
        ];

        $response = $this->actingAs($admin, 'admin')->post(route('admin.users.send-email', $user->id), $emailData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'メールが送信されました。');

        Mail::assertSent(AdminNotificationMail::class, function ($mail) use ($user, $emailData) {
            return $mail->hasTo($user->email) && $mail->subject === $emailData['subject'] && $mail->messageContent === $emailData['message'];
        });
    }
}
