<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\RatingController;
use App\Http\Controllers\user\CommentController;
use App\Http\Controllers\user\ContactController;
use App\Http\Controllers\user\PaymentController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\user\HomePageController;
use App\Http\Controllers\user\OrderListController;
use App\Http\Controllers\user\ProductDetailController;


Route::group(['prefix'=>'user','middleware'=>'userMiddleware'],function(){
    Route::get('home',[HomePageController::class,'userPage'])->name('user#page');

    Route::group(['prefix' => 'profile'],function(){
        Route::get('edit/profile',[ProfileController::class,'editPage'])->name('edit#page');
        Route::post('edit/profile',[ProfileController::class,'profileEdit'])->name('profile#edit');
        Route::get('change/password',[ProfileController::class,'changePasswordPage'])->name('change#passwordPage');
        Route::post('change/password',[ProfileController::class,'changePassword'])->name('change#password');
    });

    Route::group(['prefix' => 'product'],function(){
        Route::get('detail/{id}',[ProductDetailController::class,'detailPage'])->name('product#detailPage');
        Route::post('comment',[CommentController::class,'createComment'])->name('create#comment');
        Route::get('delete/comment/{id}',[CommentController::class,'delete'])->name('delete#comment');
        Route::post('rating',[RatingController::class,'rating'])->name('product#rating');
    });

    Route::group(['prefix' => 'cart'],function(){
        Route::post('add',[CartController::class,'addToCart'])->name('cart#add');
        Route::get('page',[CartController::class,'cartPage'])->name('cart#page');
        Route::get('delete',[CartController::class,'deleteCart'])->name('cart#delete');
        Route::get('temp/Order',[CartController::class,'tempOrder']);
    });

    Route::group(['prefix' => 'contact'],function(){
        Route::get('page',[ContactController::class,'contactPage'])->name('contact#page');
        Route::post('create',[ContactController::class,'contactCreate'])->name('contact#create');
    });

    Route::group(['prefix' => 'payment'],function(){
        Route::get('page',[PaymentController::class,'page'])->name('payment#page');
        Route::post('order',[PaymentController::class,'order'])->name('payment#order');
    });

    Route::get('orderList/page',[OrderListController::class,'page'])->name('orderList#page');
});
