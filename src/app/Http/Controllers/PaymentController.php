<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

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
        $user = Auth::user();
        $data = $request->validate([
            'payment_method' => 'required|string',
            'credit_card_number' => 'nullable|string',
            'credit_card_expiration' => 'nullable|string',
            'credit_card_cvc' => 'nullable|string',
        ]);

        $user->payment_method = $request->payment_method;
        $user->credit_card_number = $request->credit_card_number;
        $user->credit_card_expiration = $request->credit_card_expiration;
        $user->credit_card_cvc = $request->credit_card_cvc;
        $user->save();

        return redirect()->route('item.purchase', ['id' => $id])->with('status', '支払い情報が更新されました。');
    }
}
