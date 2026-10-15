<?php
use App\Http\Controllers\{AuthController, CartController, CheckoutController, OrderController, PasswordResetController, ShopController};
use App\Http\Controllers\Admin;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class,'home'])->name('home');
Route::view('/about','about')->name('about');
Route::view('/terms','terms')->name('terms');
Route::view('/privacy','privacy')->name('privacy');
Route::get('/menu', [ShopController::class,'menu'])->name('menu');
Route::get('/product/{product}', [ShopController::class,'product'])->name('product');

Route::middleware('guest')->group(function () {
    Route::view('/login','auth.login')->name('login');
    Route::post('/login',[AuthController::class,'login']);
    Route::view('/register','auth.register')->name('register');
    Route::post('/register',[AuthController::class,'register']);
    Route::get('/forgot-password',[PasswordResetController::class,'show'])->name('password.request');
    Route::post('/forgot-password',[PasswordResetController::class,'update'])->middleware('throttle:5,1')->name('password.change');
});
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/cart',[CartController::class,'index'])->name('cart');
    Route::post('/cart',[CartController::class,'add'])->name('cart.add');
    Route::patch('/cart/{id}',[CartController::class,'update'])->name('cart.update');
    Route::delete('/cart/{id}',[CartController::class,'remove'])->name('cart.remove');
    Route::get('/checkout',[CheckoutController::class,'show'])->name('checkout');
    Route::post('/checkout',[CheckoutController::class,'place'])->name('checkout.place');
    Route::get('/orders',[OrderController::class,'index'])->name('orders');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', AdminOnly::class])->group(function () {
    Route::get('/',[Admin\OrderController::class,'index'])->name('orders');
    Route::post('/orders/{order}/{action}',[Admin\OrderController::class,'act'])->whereIn('action',['accept','decline','ontheway','ready','finish','remind'])->name('orders.act');
    Route::get('/settings',[Admin\SettingsController::class,'edit'])->name('settings');
    Route::put('/settings',[Admin\SettingsController::class,'update'])->name('settings.update');
    Route::get('/audit',[Admin\AuditController::class,'index'])->name('audit');
    Route::get('/products',[Admin\ProductController::class,'index'])->name('products');
    Route::get('/products/create',[Admin\ProductController::class,'create'])->name('products.create');
    Route::post('/products',[Admin\ProductController::class,'store'])->name('products.store');
    Route::get('/products/{product}/edit',[Admin\ProductController::class,'edit'])->name('products.edit');
    Route::put('/products/{product}',[Admin\ProductController::class,'update'])->name('products.update');
    Route::patch('/products/{product}/toggle',[Admin\ProductController::class,'toggle'])->name('products.toggle');
    Route::delete('/products/{product}',[Admin\ProductController::class,'destroy'])->name('products.destroy');
    Route::get('/options',[Admin\OptionController::class,'index'])->name('options');
    Route::post('/options',[Admin\OptionController::class,'store'])->name('options.store');
    Route::post('/options/{option}',[Admin\OptionController::class,'act'])->name('options.act');
    Route::get('/password',[Admin\PasswordController::class,'edit'])->name('password');
    Route::put('/password',[Admin\PasswordController::class,'update'])->name('password.update');
});
