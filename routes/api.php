<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController as Regit;
use App\Http\Controllers\LoginController as Login;
use App\Http\Controllers\Member\ProfileController as MPF;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register',[Regit::class,'store'])->name('register');
Route::get('/userHasConfirmed',[Regit::class,'userHasConfirmed']);

Route::post('/login',[Login::class,"store"]);

Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::resource('/profile',MPF::class);
    Route::delete('/logout',[Login::class,'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
