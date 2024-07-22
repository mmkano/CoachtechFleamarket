<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Item;
use App\Models\CategoryItem;
use App\Models\Condition;
use App\Models\SoldItem;
use App\Models\Brand;
use App\Models\UserItemPaymentMethod;
use App\Http\Requests\ConfirmPurchaseRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Requests\StoreItemRequest;
use App\Mail\PaymentInformationMail;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('index', ['items' => $items]);
    }

    public function show($id)
    {
        $item = Item::with('favorites', 'comments', 'brand')->findOrFail($id);
        return view('show', ['item' => $item]);
    }

    public function purchase($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', '購入するにはログインしてください。');
        }

        $item = Item::findOrFail($id);
        $user = Auth::user();

        $userPaymentMethod = UserItemPaymentMethod::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->first();

        if (is_null($user->postal_code) || is_null($user->address)) {
            return redirect()->route('profile.edit')->with('error', '購入するには住所の登録が必要です。');
        }

        return view('purchase', [
            'item' => $item,
            'user' => $user,
            'payment_method' => $userPaymentMethod ? $userPaymentMethod->payment_method : null
        ]);
    }

    public function complete()
    {
        return view('complete');
    }

    public function confirmPurchase(ConfirmPurchaseRequest $request, $id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($id);

        $postal_code = $request->input('postal_code');
        $address = $request->input('address');
        $payment_method = $request->input('payment_method');

        $soldItem = new SoldItem();
        $soldItem->item_id = $item->id;
        $soldItem->user_id = $user->id;
        $soldItem->save();

        UserItemPaymentMethod::updateOrCreate(
            ['user_id' => $user->id, 'item_id' => $item->id],
            ['payment_method' => $request->payment_method]
        );

        if ($request->payment_method == 'credit_card') {
            return redirect()->route('item.complete', ['id' => $id])->with('status', '購入が完了しました。');
        } elseif ($request->payment_method == 'bank_transfer' || $request->payment_method == 'convenience_store') {
            Mail::to($user->email)->send(new PaymentInformationMail($user, $item, $request->payment_method));
            return redirect()->route('payment.sent')->with('status', '購入手続きの詳細をメールで送信しました。');
        }
    }

    public function address($id)
    {
        $item = Item::findOrFail($id);
        return view('address', ['item' => $item]);
    }

    public function updateAddress(UpdateAddressRequest $request, $id)
    {
        $user = Auth::user();
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building_name = $request->building_name;
        $user->save();

        return redirect()->route('item.purchase', ['id' => $id])->with('status', '配送先を更新しました。');
    }

    public function create()
    {
        $categories = CategoryItem::all();
        $conditions = Condition::all();
        $brands = Brand::all();

        return view('create', compact('categories', 'conditions', 'brands'));
    }

    public function store(StoreItemRequest $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        $input = $request->all();
        $input['price'] = str_replace('¥', '', $input['price']);

        $request->merge($input);

        $path = $request->file('img_url')->store('images', 's3');
        Storage::disk('s3')->setVisibility($path, 'public');

        $item = new Item();
        $item->name = $request->name;
        $item->price = $input['price'];
        $item->description = $request->description;
        $item->img_url = $path;
        $item->user_id = Auth::id();
        $item->category_item_id = $request->category_item_id;
        $item->condition_id = $request->condition_id;
        $item->brand_id = $request->brand_id;
        $item->save();

        return redirect()->route('home');
    }
}
