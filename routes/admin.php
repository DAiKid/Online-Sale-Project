<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\OrderBoardController;
use App\Http\Controllers\superadmin\PaymentController;
use App\Http\Controllers\superadmin\UserListController;
use App\Http\Controllers\superadmin\AdminListController;
use App\Http\Controllers\admin\SaleInformationController;
use App\Http\Controllers\superadmin\AddNewAdminController;


Route::group(['prefix'=>'admin','middleware'=>'adminMiddleware'],function(){
    Route::get('dashboard',[AdminController::class,'dashboard'])->name('admin#dashboard');
    Route::get('list',[CategoryController::class,'list'])->name('category#list');

    Route::group(['prefix' => 'category'],function(){
        Route::post('create',[CategoryController::class,'create'])->name('category#create');
        Route::get('/delete/{id}',[CategoryController::class,'delete'])->name('category#delete');
        Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category#edit');
        Route::post('update/{id}',[CategoryController::class,'update'])->name('category#update');
    });

    Route::group(['prefix' => 'product'],function(){
        Route::get('page',[ProductController::class,'page'])->name('product#page');
        Route::post('create',[Productcontroller::class,'create'])->name('product#create');
        Route::get('list/{action?}',[ProductController::class,'list'])->name('product#list');
        Route::get('detail/{id}',[ProductController::class,'detail'])->name('product#detail');
        Route::get('delete/{id}',[ProductController::class,'delete'])->name('product#delete');
        Route::get('edit/{id}',[ProductController::class,'edit'])->name('product#edit');
        Route::post('update',[Productcontroller::class,'update'])->name('product#update');
    });

    Route::group(['prefix' => 'profile'],function(){
        Route::get('page',[ProfileController::class,'page'])->name('changePassword#page');
        Route::post('update',[ProfileController::class,'update'])->name('changePassword#update');
        Route::get('editPage',[ProfileController::class,'editPage'])->name('profileEdit#page');
        Route::post('editProfile',[ProfileController::class,'editProfile'])->name('profileEdit#update');
    });

    Route::group(['middleware' => 'superAdminMiddleware'],function(){
        Route::group(['prefix' => 'payment'],function(){
            Route::get('page',[PaymentController::class,'paymentPage'])->name('payment#page');
            Route::post('create',[PaymentController::class,'paymentCreate'])->name('payment#create');
            Route::get('delete/{id}',[PaymentController::class,'paymentDelete'])->name('payment#delete');
            Route::get('edit/page/{id}',[PaymentController::class,'paymentEditPage'])->name('payment#editPage');
            Route::post('update',[PaymentController::class,'paymentUpdate'])->name('payment#update');
        });

        Route::group(['prefix' => 'profile'],function(){
            Route::get('newAdmin',[AddNewAdminController::class,'page'])->name('addNewAdmin#page');
            Route::post('newAdmin',[AddNewAdminController::class,'addAdmin'])->name('addNewAdmin#add');
            Route::get('adminList',[AdminListController::class,'adminListPage'])->name('adminList#page');
            Route::get('adminList/delete/{id}',[AdminListController::class,'adminListDelete'])->name('adminList#delete');
            Route::get('userList',[UserListController::class,'userListPage'])->name('userList#page');
            Route::get('userList/delete/{id}',[UserListController::class,'userListDelete'])->name('userList#delete');
        });

        Route::group(['prefix' => 'order'],function(){
            Route::get('list/page/{action?}',[OrderBoardController::class,'orderListPage'])->name('orderList#page');
            Route::get('detail/page/{orderCode}',[OrderBoardController::class,'orderDetailPage'])->name('orderDetail#page');
            Route::get('status/change',[OrderBoardController::class,'statusChange']);
            Route::get('reject',[OrderBoardController::class,'orderReject']);
            Route::get('accept',[OrderBoardController::class,'orderAccept']);
        });

        Route::group(['prefix' => 'sale'],function(){
            Route::get('info',[SaleInformationController::class,'saleInfoPage'])->name('sale#info');
            Route::get('detail/page/{orderCode}',[SaleInformationController::class,'saleDetailPage'])->name('saleDetail#page');
        });
    });
});




