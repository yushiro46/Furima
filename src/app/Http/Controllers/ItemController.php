<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return view('index', compact('user'));
        }
        
        return view('index');
    }
}
