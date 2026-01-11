<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);

        $user = Auth::user();

        return view('purchase', compact('item', 'user'));
    }

    public function editAddress($item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        return view('address_edit', compact('user', 'item'));
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 郵便番号はハイフンを除去して保存（例：123-4567 → 1234567）
        $postal = str_replace('-', '', $request->postal_code);

        $user->update([
            'postal_code' => $postal,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase.show', ['item_id' => $item_id]);
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('sell', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $path = $request->file('image')->store('products', 'public');

        $filename = basename($path);

        $item = Item::create([
            'user_id' => $user->id,
            'condition_id' => $request->condition_id,
            'image' => $filename,
            'name' => $request->name,
            'brand' => $request->brand,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        $item->categories()->sync($request->category_ids);

        return redirect('/');
    }

    public function pay(PurchaseRequest $request, $item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        // すでに購入済みチェック
        if ($item->purchases()->exists()) {
            return redirect()
                ->route('purchase.show', $item_id)
                ->with('error', 'この商品はすでに購入されています');
        }

        // 購入履歴保存（※テスト環境想定）
        Purchase::firstOrCreate([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // Stripe APIキー設定
        Stripe::setApiKey(config('services.stripe.secret'));

        // Stripe Checkout セッション作成
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        // JPY は最小単位が「円」なので ×100 は不要
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => url('/mypage'),
            'cancel_url'  => url('/purchase/' . $item_id),
        ]);

        // Stripe 決済画面へリダイレクト
        return redirect()->away($session->url);
    }
}
