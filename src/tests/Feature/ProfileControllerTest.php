<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('edit-profile');
        $response->assertViewHas('user', $user);
    }

    public function test_update_profile()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'profile_image' => 'profile_images/old_image.jpg',
        ]);

        $newImage = UploadedFile::fake()->image('new_image.jpg');

        $response = $this->actingAs($user)->post(route('profile.update'), [
            'name' => 'Updated Name',
            'postal_code' => '123-4567',
            'address' => 'Updated Address',
            'building_name' => 'Updated Building',
            'profile_image' => $newImage,
        ]);

        $response->assertRedirect(route('mypage'));
        $response->assertSessionHas('success', 'プロフィールが更新されました。');

        $newImagePath = 'profile_images/' . $newImage->hashName();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'postal_code' => '123-4567',
            'address' => 'Updated Address',
            'building_name' => 'Updated Building',
            'profile_image' => $newImagePath,
        ]);

        Storage::disk('public')->assertExists($newImagePath);
        Storage::disk('public')->assertMissing('profile_images/old_image.jpg');
    }
}
