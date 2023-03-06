<?php

use App\Http\Controllers\ItemsController;
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

Route::get('', [App\Http\Controllers\ItemsController::class, 'showItems'])->name('top');

Route::get('/sell', [App\Http\Controllers\SellController::class, 'showSellForm'])->name('sell');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/items/cart', [App\Http\Controllers\ItemsController::class, 'showCartItem'])->name('show.item.cart');
Route::post('/items/cart/add', [App\Http\Controllers\ItemsController::class, 'addCartItem'])->name('add.item.cart');
Route::post('/items/cart/delete', [App\Http\Controllers\ItemsController::class, 'deleteCartItem'])->name('delete.item.cart');
Route::get('/items/{item}', [App\Http\Controllers\ItemsController::class, 'showDetail'])->name('item.showDetail');
