<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\UserItemPaymentMethod;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Mockery;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_payment_method()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $userPaymentMethod = UserItemPaymentMethod::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'credit_card'
        ]);

        $response = $this->actingAs($user)->get(route('payment.change', ['id' => $item->id]));

        $response->assertStatus(200);
        $response->assertViewIs('payment');
        $response->assertViewHas('item', $item);
        $response->assertViewHas('user', $user);
        $response->assertViewHas('amount', $item->price);
        $response->assertViewHas('userPaymentMethod', 'credit_card');
    }

    public function test_update_payment_method_with_credit_card()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $mock = Mockery::mock('overload:' . PaymentIntent::class);
        $mock->shouldReceive('create')->andReturn((object) [
            'client_secret' => 'pi_3PegS8B1opHs8wxj095nBFmD_secret_Kf05y3QvG9uF1xvNNejvgB2M7'
        ]);

        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('payment.update', ['id' => $item->id]), [
            'amount' => 1000,
            'payment_method' => 'credit_card',
            'payment_method_id' => 'pm_card_visa'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'client_secret' => 'pi_3PegS8B1opHs8wxj095nBFmD_secret_Kf05y3QvG9uF1xvNNejvgB2M7'
        ]);

        $this->assertDatabaseHas('user_item_payment_methods', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'credit_card'
        ]);
    }

    public function test_update_payment_method_with_other()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('payment.update', ['id' => $item->id]), [
            'amount' => 1000,
            'payment_method' => 'bank_transfer'
        ]);

        $response->assertRedirect(route('item.purchase', ['id' => $item->id]));
        $response->assertSessionHas('status', '支払い方法が更新されました。');

        $this->assertDatabaseHas('user_item_payment_methods', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'bank_transfer'
        ]);
    }
}
