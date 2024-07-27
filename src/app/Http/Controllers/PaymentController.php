<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\UserItemPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function changePaymentMethod($id)
    {
        $item = Item::findOrFail($id);
        $user = Auth::user();
        $userPaymentMethod = UserItemPaymentMethod::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->first();

        return view('payment', [
            'item' => $item,
            'user' => $user,
            'amount' => $item->price * 1,
            'userPaymentMethod' => $userPaymentMethod ? $userPaymentMethod->payment_method : null
        ]);
    }

    public function updatePaymentMethod(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $user = Auth::user();

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);

        $paymentMethod = $request->input('payment_method');

        if ($paymentMethod === 'credit_card') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            try {
                $paymentIntent = PaymentIntent::create([
                    'amount' => $request->amount,
                    'currency' => 'jpy',
                    'payment_method' => $request->input('payment_method_id'),
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                    'return_url' => route('item.purchase', ['id' => $id]),
                ]);

                UserItemPaymentMethod::updateOrCreate(
                    ['user_id' => $user->id, 'item_id' => $item->id],
                    ['payment_method' => 'credit_card']
                );

                return response()->json([
                    'client_secret' => $paymentIntent->client_secret,
                ]);
            } catch (\Exception $e) {
                Log::error('Error creating payment intent', ['error' => $e->getMessage()]);
                return redirect()->route('payment.change', ['id' => $id])->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            UserItemPaymentMethod::updateOrCreate(
                ['user_id' => $user->id, 'item_id' => $item->id],
                ['payment_method' => $paymentMethod]
            );

            return redirect()->route('item.purchase', ['id' => $id])->with('status', '支払い方法が更新されました。');
        }
    }
}
