<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocailLoginController;

require __DIR__.'/auth.php';
require_once __DIR__.'/user.php';
require_once __DIR__.'/admin.php';

Route::get('/', function () {
    return view('authentication/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/auth/{provider}/redirect',[SocailLoginController::class,'redirect'])->name('socialLogin');

Route::get('/auth/{provider}/callback',[SocailLoginController::class,'rollback'])->name('socialRollback');


