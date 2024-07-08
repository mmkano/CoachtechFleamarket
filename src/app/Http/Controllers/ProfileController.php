<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stripe\Stripe;
use Stripe\Customer;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');

            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $user->profile_image = $path;
        }

        $user->name = $request->name ?: $user->email;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building_name = $request->building_name;

        Stripe::setApiKey(config('services.stripe.secret'));

        if (!$user->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $user->email,
                'name' => $user->name,
                'source' => $request->stripeToken,
            ]);
            $user->stripe_customer_id = $customer->id;
        } else {
            $customer = Customer::retrieve($user->stripe_customer_id);
            $customer->source = $request->stripeToken;
            $customer->save();
        }

        $user->credit_card_number = $request->credit_card_number;
        $user->credit_card_expiration = $request->credit_card_expiration;
        $user->credit_card_cvc = $request->credit_card_cvc;
        $user->bank_account_number = $request->bank_account_number;
        $user->bank_branch_name = $request->bank_branch_name;
        $user->bank_branch_code = $request->bank_branch_code;
        $user->bank_name = $request->bank_name;
        $user->bank_account_type = $request->bank_account_type;
        $user->bank_account_holder = $request->bank_account_holder;

        $user->save();

        return redirect()->route('home');
    }
}
