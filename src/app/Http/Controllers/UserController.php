<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function mypage(Request $request)
    {
        $user = Auth::user();

        $pageType = $request->query('page', 'sell');

        if ($pageType === 'buy') {
            $items = Item::whereHas('purchases', function ($purchaseQuery) use ($user) {
                $purchaseQuery->where('user_id', $user->id);
            })->get();
        } else {
            $items = Item::where('user_id', $user->id)->get();
        }

        return view('profile', compact('user', 'items', 'pageType'));
    }

    public function editProfile()
    {
        $user = Auth::user();

        return view('profile_edit', compact('user'));
    }

    public function updateProfile(ProfileRequest $request)
    {
        /** @var App\Models\User $user */
        $user = Auth::user();

        $postal = str_replace('-', '', $request->postal_code);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $filename = basename($path);
        } else {
            $filename = $user->avatar;
        }

        $user->update([
            'name'        => $request->name,
            'avatar'      => $filename,
            'postal_code' => $postal,
            'address'     => $request->address,
            'building'    => $request->building,
        ]);

        return redirect('/mypage');
    }

    public function create()
    {
        $user = Auth::user();

        return view('profile_setup', compact('user'));
    }

    public function ProfileSetup(ProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $postal = str_replace('-', '', $request->postal_code);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $filename = basename($path);
        } else {
            $filename = null;
        }

        $user->update([
            'name' => $request->name,
            'avatar' => $filename,
            'postal_code' => $postal,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect('/');
    }
}
