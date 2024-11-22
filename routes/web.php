<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'account'],function(){
  //--Guset middleware routes
  Route::group(['middleware' => 'guest'],function(){
    Route::get('/login',[LoginController::class,'index'])->name('account.login');
    Route::get('/register',[LoginController::class,'register'])->name('account.register');
    Route::post('/process-register',[LoginController::class,'processRegister'])->name('account.processRegister');
    Route::post('/account/authenticate',[LoginController::class,'authenticate'])->name('account.authenticate');
  });
  //--Authenticated Middleware
  Route::group(['middleware' => 'auth'],function(){
    Route::get('logout',[LoginController::class,'logout'])->name('account.logout');
    Route::get('dashboard',[DashboardController::class,'index'])->name('account.dashboard');
  });
});


Route::group(['prefix' => 'admin'], function(){

  Route::group(['middelware'=> 'admin.guest'], function(){
    Route::get('/login',[AdminController::class,'index'])->name('admin.login');
    Route::post('/authenticate',[AdminController::class,'authenticate'])->name('admin.authenticate');
  });

  Route::group(['middelware'=> 'admin.auth'], function(){
    Route::get('/dashboard',[ AdminDashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/logout',[AdminController::class,'logout'])->name('admin.logout');
  });

});






