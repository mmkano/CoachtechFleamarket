<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

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

Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('/', function () {
    return view('index');
})->name('home')->middleware('auth');

Route::controller(ItemController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/item/{id}', 'show')->name('item.show');
    Route::get('/item/{id}/purchase', 'purchase')->name('item.purchase');
    Route::get('/item/{id}/address', 'address')->name('address');
    Route::post('/address/update', 'updateAddress')->name('address.update');
    Route::get('/create', 'create')->name('create');
    Route::post('/create', 'store')->name('item.store');
    Route::get('/item/{id}/comments', 'showComments')->name('item.comments');
    Route::post('/item/{id}/comments', 'submitComment')->name('item.comment.submit');
});

Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});