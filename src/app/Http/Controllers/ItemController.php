<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // ?tab=xxx を取得（未指定なら null）
        $tab = $request->query('tab');

        $query = Item::with('purchases');

        // ログイン中は「自分が出品した商品」を除外
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        if ($tab === 'mylist') {

            // 未ログインならログイン画面へ
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            // 自分がいいねした商品だけ
            $items = $query
                ->whereHas('likes', function ($likeQuery) {
                    $likeQuery->where('user_id', Auth::id());
                })
                ->orderBy('id')
                ->paginate(8);
        } elseif ($tab === 'recommend') {

            $items = $query
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->orderBy('id')
                ->paginate(8);
        } else {

            $items = $query
                ->orderBy('id')
                ->paginate(8);
        }

        // ログイン状態で表示する Blade を切り替え
        return Auth::check()
            ? view('index', compact('items', 'tab'))
            : view('index_guest', compact('items', 'tab'));
    }


    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Item::query();

        if (!empty($keyword)) {
            $query->where(function ($searchQuery) use ($keyword) {
                $searchQuery->where('name', 'like', "%{$keyword}%")
                    ->orWhere('brand', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }
        $items = $query->orderBy('id')->paginate(8)->withQueryString();

        if (Auth::check()) {
            return view('index', compact('items', 'keyword'));
        }

        return view('index_guest', compact('items', 'keyword'));
    }

    public function show($item_id)
    {
        $item = Item::with(['categories', 'condition', 'likes', 'comments.user'])->findOrFail($item_id);

        if (Auth::check()) {
            return view('show', compact('item'));
        }

        return view('show_guest', compact('item'));
    }
}
