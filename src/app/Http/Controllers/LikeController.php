<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($item_id)
    {
        $existing = Like::where('user_id', Auth::id())->where('item_id', $item_id)->first();

        if ($existing) {
            $existing->delete();
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'item_id' => $item_id
            ]);
        }
        return back();
    }
}
