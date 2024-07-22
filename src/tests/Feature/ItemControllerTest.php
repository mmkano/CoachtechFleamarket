<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\UserItemPaymentMethod;
use App\Models\CategoryItem;
use App\Models\Condition;
use App\Models\Brand;
use App\Models\SoldItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\PaymentInformationMail;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $items = Item::factory()->count(3)->create();

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('index');
        $response->assertViewHas('items', function ($viewItems) use ($items) {
            return $viewItems->pluck('id')->sort()->values()->all() === $items->pluck('id')->sort()->values()->all();
        });
    }

    public function test_show()
    {
        $item = Item::factory()->create();

        $response = $this->get(route('item.show', ['id' => $item->id]));

        $response->assertStatus(200);
        $response->assertViewIs('show');
        $response->assertViewHas('item', $item);
    }

    public function test_purchase_redirects_if_not_logged_in()
    {
        $item = Item::factory()->create();

        $response = $this->get(route('item.purchase', ['id' => $item->id]));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', '購入するにはログインしてください。');
    }

    public function test_purchase_shows_purchase_page_if_logged_in_and_address_registered()
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => 'Test Address'
        ]);
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->get(route('item.purchase', ['id' => $item->id]));

        $response->assertStatus(200);
        $response->assertViewIs('purchase');
        $response->assertViewHas('item', $item);
        $response->assertViewHas('user', $user);
    }

    public function test_purchase_redirects_to_profile_edit_if_address_not_registered()
    {
        $user = User::factory()->create([
            'postal_code' => null,
            'address' => null
        ]);
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->get(route('item.purchase', ['id' => $item->id]));

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('error', '購入するには住所の登録が必要です。');
    }

    public function test_confirm_purchase_sends_email_for_bank_transfer()
    {
        Mail::fake();

        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('item.confirm-purchase', ['id' => $item->id]), [
            'postal_code' => '123-4567',
            'address' => 'Test Address',
            'payment_method' => 'bank_transfer'
        ]);

        $response->assertRedirect(route('payment.sent'));
        $response->assertSessionHas('status', '購入手続きの詳細をメールで送信しました。');

        Mail::assertSent(PaymentInformationMail::class, function ($mail) use ($user, $item) {
            return $mail->hasTo($user->email) && $mail->user->id === $user->id && $mail->item->id === $item->id;
        });
    }

    public function test_update_address()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('address.update', ['id' => $item->id]), [
            'postal_code' => '123-4567',
            'address' => 'Updated Address',
            'building_name' => 'Updated Building'
        ]);

        $response->assertRedirect(route('item.purchase', ['id' => $item->id]));
        $response->assertSessionHas('status', '配送先を更新しました。');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'postal_code' => '123-4567',
            'address' => 'Updated Address',
            'building_name' => 'Updated Building'
        ]);
    }

    public function test_create()
    {
        $user = User::factory()->create();
        $categories = CategoryItem::factory()->count(3)->create();
        $conditions = Condition::factory()->count(3)->create();
        $brands = Brand::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('create'));

        $response->assertStatus(200);
        $response->assertViewIs('create');
        $response->assertViewHas('categories', function ($viewCategories) use ($categories) {
            return $viewCategories->pluck('id')->sort()->values()->all() === $categories->pluck('id')->sort()->values()->all();
        });
        $response->assertViewHas('conditions', function ($viewConditions) use ($conditions) {
            return $viewConditions->pluck('id')->sort()->values()->all() === $conditions->pluck('id')->sort()->values()->all();
        });
        $response->assertViewHas('brands', function ($viewBrands) use ($brands) {
            return $viewBrands->pluck('id')->sort()->values()->all() === $brands->pluck('id')->sort()->values()->all();
        });
    }

    public function test_store()
    {
        Storage::fake('s3');

        $user = User::factory()->create();
        $category = CategoryItem::factory()->create();
        $condition = Condition::factory()->create();
        $brand = Brand::factory()->create();

        $itemData = [
            'name' => 'Test Item',
            'price' => 1000,
            'description' => 'Test Description',
            'img_url' => UploadedFile::fake()->image('test_image.jpg'),
            'category_item_id' => $category->id,
            'condition_id' => $condition->id,
            'brand_id' => $brand->id,
        ];

        $response = $this->actingAs($user)->post(route('item.store'), $itemData);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $this->assertDatabaseHas('items', [
            'name' => 'Test Item',
            'price' => 1000,
            'description' => 'Test Description',
            'user_id' => $user->id
        ]);

        Storage::disk('s3')->assertExists('images/' . $itemData['img_url']->hashName());
    }
}
