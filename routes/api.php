<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController as Regit;
use App\Http\Controllers\LoginController as Login;
use App\Http\Controllers\Member\ProfileController as MPF;
use App\Http\Controllers\VisitorController as VISIT;
use App\Http\Controllers\WhatnewController as WN;

/* admin route */
use App\Http\Controllers\Admin\UserController as AUSER;
use App\Http\Controllers\Admin\DashboardController as AHOME;
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

/* ============ whatnew
 *
 * */
Route::get('/whatnew',[WN::class,'getWhatnew']);

/* ====== Visitor 25 Nov 2021 */
Route::resource('/visitor',VISIT::class);

Route::post('/checkpasssport',[Login::class,'checkPassSport'])
    ->name('checkPassSport');
Route::post('/login',[Login::class,"store"]);

/*
Route::group(['middleware' => ['auth:sanctum']],function(){

});
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



/* make a route prefix for member group */
Route::prefix("member")->name("member.")->middleware('auth:sanctum')
                                        ->group(function(){

    /* ============= member profile 24 Nov 2021 ====================
     * 
     * */                                        
    Route::resource('/profile',MPF::class);
    Route::post('/check-confirm-key',[MPF::class,'checkConfirmKey'])
        ->name('check-member-profile-confirm-key');

    /* Logout from member */
    Route::delete('/logout',[Login::class,'destroy'])->name('logout');
                                        });



Route::prefix("admin")->name("admin.")->middleware('auth:sanctum')
      ->group(function(){
    Route::resource('/user',AUSER::class);
    Route::resource('/home',AHOME::class);

    // whatnew 
    Route::resource('/whatnew',WN::class);
    
    // get whatnew will be use dashboard
    Route::get('/getwhatnew',[AHOME::class,'getWhatnew'])
        ->name('getWhatnew');



});
