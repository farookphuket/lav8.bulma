<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController as Regit;
use App\Http\Controllers\LoginController as Login;
use App\Http\Controllers\Member\ProfileController as MPF;
use App\Http\Controllers\Member\DashboardController as MHOME;
use App\Http\Controllers\PostController as Post;
use App\Http\Controllers\CategoryController as Cat;

// user role 
use App\Http\Controllers\RoleController as uRole;

use App\Http\Controllers\VisitorController as VISIT;
use App\Http\Controllers\WhatnewController as WN;
use App\Http\Controllers\TagController as Tag;


/* admin route */
use App\Http\Controllers\Admin\UserController as AUSER;
use App\Http\Controllers\Admin\DashboardController as AHOME;
use App\Http\Controllers\Admin\AboutController as AB;

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

/* ============ public post route 1 Nov 2021
 *
 * */
Route::get('/getpost',[Post::class,'getPost'])->name('getPost');

// get about page on 10 Dec 2021
Route::get('/getabout',[Post::class,'getAbout'])->name('getAbout');

Route::get('/post/{post:slug}',[Post::class,'show']);

// tag as public
Route::get("/tag",[Tag::class,"getTag"])->name("getTag");

// public category 
Route::get('/category',[Cat::class,'getCategory'])->name('getCategory');

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

    // member dashboard
    Route::resource('/dashboard',MHOME::class);

    // get whatnew will get from dashboard
    Route::get('/getwhatnew',[MHOME::class,'getWhatnew'])
        ->name("getWhatnew");

    // CRUD with whatnew
    Route::resource('/whatnew',WN::class);

    // Post 
    Route::resource('/post',Post::class);
    Route::get('/getpost',[Post::class,'mGetPost'])
        ->name('mGetPost');


    // Tag 
    Route::resource("/tag",Tag::class);

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
    Route::get('/getuser',[AUSER::class,"getUser"])->name("getUser");

    Route::resource('/home',AHOME::class);

    Route::resource('/about',AB::class);

    // whatnew 
    Route::resource('/whatnew',WN::class);
    
    // get whatnew will be use dashboard
    Route::get('/getwhatnew',[AHOME::class,'getWhatnew'])
        ->name('getWhatnew');

    /* ====================== post section ====================================
     *
     * */
    // post 
    Route::resource('/post',Post::class);
    // get post from post controller as admin
    Route::get('/getpost',[Post::class,'aGetPost'])->name('aGetPost');
    /* ========================================================================
     *
     * */

    /* ================== Category ============================================
     *
     * */
    Route::resource("/category",Cat::class);
    Route::get('/getcategory',[Cat::class,'aGetCategory'])
        ->name('aGetCategory');

    /* ========================================================================
     *
     * */

    Route::resource('/role',uRole::class);
    Route::get('/getrole',[uRole::class,'getUserRole'])
        ->name('getUserRole');

    // tag 
    Route::resource('/tag',Tag::class);
    Route::get('/gettag',[Tag::class,"mGetTag"])->name("mGetTag");

});
