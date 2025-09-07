<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[HomeController::class,'index'])->name('home');
Route::group(['account'],function(){
    //Guest Routes
    Route::group(['middleware'=>'guest'],function(){
        Route::get('/account/register',[AccountController::class,'registrationPage'])->name('account.registration');
        Route::get('/account/login',[AccountController::class,'loginPage'])->name('account.login');
        Route::post('/account/process-register',[AccountController::class,'processRgistration'])->name('account.process.registration');
        Route::post('/account/process-login',[AccountController::class,'processLogin'])->name('account.process.login');

    });
    //Authenticated Routes
    Route::group(['middleware'=>'auth'],function(){
        Route::get('/account/profile',[AccountController::class,'profilePage'])->name('account.profile');
        Route::get('/account/logout',[AccountController::class,'logout'])->name('account.logout');
        Route::post('/account/update-profile',[AccountController::class,'updateProfile'])->name('account.update.profile');
        Route::post('/account/change-password', [AccountController::class, 'changePassword'])->name('account.change.password');
    });
});