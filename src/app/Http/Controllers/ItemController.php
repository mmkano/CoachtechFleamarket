<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\CategoryItem;
use App\Models\Condition;
use App\Models\SoldItem;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentInformationMail;
use Illuminate\Support\Facades\Log;
use App\Models\UserItemPaymentMethod;

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

    public function confirmPurchase(Request $request, $id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($id);

        $request->merge([
            'postal_code' => $user->postal_code,
            'address' => $user->address,
        ]);

        $validator = \Validator::make($request->all(), [
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ], [
            'postal_code.required' => '郵便番号を登録してください。',
            'address.required' => '住所を登録してください。',
            'payment_method.required' => '支払い方法を選択してください。',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('item.purchase', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

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

    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);

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

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        $input = $request->all();
        $input['price'] = str_replace('¥', '', $input['price']);

        $request->merge($input);
        $request->validate([
            'img_url' => 'required|image',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category_item_id' => 'required|integer',
            'condition_id' => 'required|integer',
            'brand_id' => 'nullable|integer',
        ]);

        $path = $request->file('img_url')->store('images', 'public');

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

        return redirect()->route('home')->with('status', '商品を出品しました。');
    }
}
