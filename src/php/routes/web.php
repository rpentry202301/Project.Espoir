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
Route::get('/items/{item}', [\App\Http\Controllers\ItemsController::class, 'showDetail'])->name('item.showDetail');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
  // 商品購入機能のパスはここに記述する
});


Route::middleware('judge_admin')->group(function () {
  Route::get('/sell', [App\Http\Controllers\SellController::class, 'showSellForm'])->name('sell');
  Route::post('/sell', [App\Http\Controllers\SellController::class, 'registerItem'])->name('sell');
});

Route::prefix('mypage')
  ->namespace('MyPage')
  ->middleware('auth')
  ->group(function () {
    Route::get('/edit-profile', [App\Http\Controllers\MyPage\ProfileController::class, 'showProfileEditForm'])->name('mypage.edit-profile');
    Route::post('/edit-profile', [App\Http\Controllers\MyPage\ProfileController::class, 'editProfile'])->name('mypage.edit-profile');
  });
