<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/search', [ItemController::class, 'search']);
Route::get('/item/{item_id}', [ItemController::class, 'show']);
// メール認証誘導画面
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// メール内リンク
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/profile/setup');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証メール再送
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware('auth')->group(function () {
    Route::post('/item/{item_id}/like', [LikeController::class, 'toggle']);
    Route::post('/item/{item_id}/comment', [CommentController::class, 'store']);
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress']);
    Route::post('/address/update/{item_id}', [PurchaseController::class, 'updateAddress']);
    Route::get('/mypage', [UserController::class, 'mypage']);
    Route::get('/mypage/profile', [UserController::class, 'editProfile']);
    Route::post('/mypage/profile', [UserController::class, 'updateProfile']);
    Route::get('/profile/setup', [UserController::class, 'create']);
    Route::post('/profile/setup', [UserController::class, 'ProfileSetup']);
    Route::get('/sell', [PurchaseController::class, 'create']);
    Route::post('/items', [PurchaseController::class, 'store']);
    Route::post('/purchase/{item_id}/pay', [PurchaseController::class, 'pay']);
});
