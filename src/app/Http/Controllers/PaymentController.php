<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Item;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Mail\PaymentInformationMail;

class PaymentController extends Controller
{
    public function changePaymentMethod($id)
    {
        $item = Item::findOrFail($id);
        $user = Auth::user();
        return view('payment', ['item' => $item, 'user' => $user]);
    }

    public function updatePaymentMethod(Request $request, $id)
{
    $item = Item::findOrFail($id);
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

            $item->payment_method = 'credit_card';
            $item->save();

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating payment intent', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    } else {
        // 銀行振込やコンビニ払いの場合
        $item->payment_method = $paymentMethod;
        $item->save();

        return response()->json(['success' => true]);
    }
}



    public function completePayment(Request $request, $id)
    {
        Log::info('Payment completed successfully for item ID: ' . $id);
        return redirect()->route('item.purchase', ['id' => $id])->with('status', '購入が完了しました。');
    }
}
