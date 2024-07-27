<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchController;

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
    Route::post('/item/{id}/address/update', 'updateAddress')->name('address.update');
    Route::post('/item/{id}/confirm-purchase', 'confirmPurchase')->name('item.confirm-purchase');
    Route::get('/create', 'create')->name('create');
    Route::post('/create', 'store')->name('item.store');
    Route::get('/complete', 'complete')->name('item.complete');
});

Route::controller(CommentController::class)->group(function () {
    Route::get('/item/{id}/comments', 'showComments')->name('comments.show');
    Route::post('/item/{id}/comments', 'submitComment')->name('comments.submit');
    Route::delete('/item/{item}/comments/{comment}', 'deleteComment')->name('comments.delete');
});

Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::controller(FavoriteController::class)->group(function () {
    Route::post('/favorite/{item}', 'toggleFavorite')->name('favorite.toggle');
    Route::delete('/favorite/{item}', 'destroy')->name('favorite.destroy');
});

Route::controller(PaymentController::class)->group(function () {
    Route::get('/item/{id}/change-payment', 'changePaymentMethod')->name('payment.change');
    Route::post('/item/{id}/update-payment', 'updatePaymentMethod')->name('payment.update');
    Route::post('/item/{id}/complete-payment', 'completePayment')->name('payment.complete');
});

Route::get('/payment/sent', function () {
    return view('sent');
})->name('payment.sent');

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('users', [AdminController::class, 'index'])->name('admin.users');
        Route::get('users/{id}', [AdminController::class, 'show'])->name('admin.users.show');
        Route::delete('users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::delete('comments/{id}', [AdminController::class, 'deleteComment'])->name('admin.comments.delete');
        Route::post('users/{id}/send-email', [AdminController::class, 'sendEmail'])->name('admin.users.send-email');
    });
});

Route::controller(SearchController::class)->prefix('search')->group(function () {
    Route::get('/', 'search')->name('items.search');
    Route::get('/category', 'searchByCategory')->name('items.search.category');
    Route::get('/condition', 'searchByCondition')->name('items.search.condition');
    Route::get('/brand', 'searchByBrand')->name('items.search.brand');
});