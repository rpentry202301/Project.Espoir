<?php

use App\Http\Controllers\ItemsController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\MyPage\ProfileController;
use Illuminate\Support\Facades\Route;

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


Auth::routes();
Route::get('', [App\Http\Controllers\ItemsController::class, 'showItems'])->name('top');

//カート機能のルート
Route::get('/items/cart', [App\Http\Controllers\CartController::class, 'showCartItem'])->name('show.item.cart');
Route::post('/items/cart/add-Item', [App\Http\Controllers\CartController::class, 'addCartItem'])->name('add.item.cart');
Route::post('/items/cart/delete-Item', [App\Http\Controllers\CartController::class, 'deleteCartItem'])->name('delete.item.cart');
Route::post('/items/cart/add-Topping', [App\Http\Controllers\CartController::class, 'addCartTopping'])->name('add.topping.cart');


Route::get('items/{item}', [\App\Http\Controllers\ItemsController::class, 'showDetail'])->name('item.showDetail');
Route::controller(ItemsController::class)->group(function () {
    Route::prefix('items')
        ->middleware('auth')
        ->group(function () {
        });
    Route::prefix('items')
        ->middleware('judge_admin')
        ->group(function () {
            Route::get('/{item}/edit', 'showEditForm')->name('item.showEditForm');
            Route::get('/{item}/stop', 'stopSelling')->name('item.stopSelling');
            Route::get('/{item}/restart', 'restartSelling')->name('item.restartSelling');
        });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    // 商品購入機能のパスはここに記述する
    Route::get('/buy-form', [App\Http\Controllers\BuyController::class, 'showBuyForm'])->name('buy.form');
    Route::post('/buy-form', [App\Http\Controllers\BuyController::class, 'buyOrderItems'])->name('buy.form');
});

Route::middleware('judge_admin')->group(function () {
    Route::get('/sell', [App\Http\Controllers\SellController::class, 'showSellForm'])->name('sell');
    Route::post('/sell', [App\Http\Controllers\SellController::class, 'registerItem'])->name('sell');
    Route::post('/sell/update', [App\Http\Controllers\SellController::class, 'updateSellInformation'])->name('sell.updateSellInformation');
});

Route::prefix('mypage')
    ->namespace('MyPage')
    ->middleware('auth')
    ->group(function () {
        Route::get('/edit-profile', [App\Http\Controllers\MyPage\ProfileController::class, 'showProfileEditForm'])->name('mypage.edit-profile');
        Route::post('/edit-profile', [App\Http\Controllers\MyPage\ProfileController::class, 'editProfile'])->name('mypage.edit-profile');
    });

Route::middleware('auth')->group(function () {
    Route::get('/purchase-history', [App\Http\Controllers\PurchaseHistoryController::class, 'showPurchaseHistory'])->name('purchase-history');
    Route::post('/purchase-history', [App\Http\Controllers\PurchaseHistoryController::class, 'cvsExport'])->name('cvs-export');
});

Route::get('/mail/send',[App\Http\Controllers\MailController::class, 'send'])->name('mail.send');