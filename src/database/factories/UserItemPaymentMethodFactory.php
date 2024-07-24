<?php

namespace Database\Factories;

use App\Models\UserItemPaymentMethod;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserItemPaymentMethodFactory extends Factory
{
    protected $model = UserItemPaymentMethod::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
            'payment_method' => $this->faker->randomElement(['credit_card', 'convenience_store', 'bank_transfer']),
        ];
    }
}
