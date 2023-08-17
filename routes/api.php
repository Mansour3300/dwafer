<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Home\HomeBlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Home\HomeSearchController;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\Home\HomeProjectController;
use App\Http\Controllers\Provider\ProfileController;
use App\Http\Controllers\Provider\ProjectController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Home\HomeCategoryController;
use App\Http\Controllers\Home\HomeProviderController;
use App\Http\Controllers\Home\HomeSubCategoryController;
use App\Http\Controllers\Provider\ProviderAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers\Client',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class,'login'])->middleware('checkactivation');
    Route::get('logout', [AuthController::class,'logout'])->middleware('auth');
    Route::post('register', [AuthController::class,'register']);
    Route::post('forgotpass', [AuthController::class,'forgot']);
    Route::post('resetcode', [AuthController::class,'resetcode']);
    Route::post('reset', [AuthController::class,'resetpass']);
    Route::post('activation', [AuthController::class,'verifyAccount']);

});


/*-------------------------------------------------------*/

Route::group([

    'middleware' => ['api'],/**'checkadmin'*/
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'admin'

], function ($router) {

    Route::post('country/store',[CountryController::class,'store']);
    Route::post('country/update/{id}',[CountryController::class,'update']);
    Route::get('country/show/{id}',[CountryController::class,'show']);
    Route::get('country/index',[CountryController::class,'index']);  //اعرضه من غير
    Route::get('country/delete/{id}',[CountryController::class,'destroy']);

    Route::post('login', [AdminAuthController::class,'login'])->middleware('checkactivation');
    Route::get('logout', [AdminAuthController::class,'logout']);
    Route::post('register', [AdminAuthController::class,'adminRegister']);
    Route::post('forgotpass', [AdminAuthController::class,'forgot']);
    Route::post('resetcode', [AdminAuthController::class,'resetcode']);
    Route::post('reset', [AdminAuthController::class,'resetpass']);
    Route::post('activation', [AdminAuthController::class,'verifyAccount']);
    Route::get('delete/{id}', [AdminAuthController::class,'destroy'])->middleware('checksuperadmin');

    Route::post('blog/store',[BlogController::class,'store']);
    Route::post('blog/update/{id}',[BlogController::class,'update']);
    Route::get('blog/show/{id}',[BlogController::class,'show']);
    Route::get('blog/index',[BlogController::class,'index']);
    Route::get('blog/delete/{id}',[BlogController::class,'destroy']);

    Route::post('category/store',[CategoryController::class,'store']);
    Route::post('category/update/{id}',[CategoryController::class,'update']);
    Route::get('category/show/{id}',[CategoryController::class,'show']);
    Route::get('category/index',[CategoryController::class,'index']);
    Route::get('category/delete/{id}',[CategoryController::class,'destroy']);

    Route::post('subcategory/store',[SubCategoryController::class,'store']);
    Route::post('subcategory/update/{id}',[SubCategoryController::class,'update']);
    Route::get('subcategory/show/{id}',[SubCategoryController::class,'show']);
    Route::get('subcategory/index',[SubCategoryController::class,'index']);
    Route::get('subcategory/delete/{id}',[SubCategoryController::class,'destroy']);

    Route::post('slider/store',[SliderController::class,'store']);
    Route::post('slider/update/{id}',[SliderController::class,'update']);
    Route::get('slider/show/{id}',[SliderController::class,'show']);
    Route::get('slider/index',[SliderController::class,'index']);
    Route::get('slider/delete/{id}',[SliderController::class,'destroy']);


});

/*---------------------------------------------------*/

Route::group([

    'middleware' => ['api'],/*,auth:developer*/
    'namespace' => 'App\Http\Controllers\Provider',
    'prefix' => 'provider'

], function ($router) {
    Route::post('login', [ProviderAuthController::class,'login'])->middleware('checkprovideractivation');
    Route::get('logout', [ProviderAuthController::class,'logout']);
    Route::post('register', [ProviderAuthController::class,'register']);
    Route::post('forgotpass', [ProviderAuthController::class,'forgot']);
    Route::post('resetcode', [ProviderAuthController::class,'resetcode']);
    Route::post('reset', [ProviderAuthController::class,'resetpass']);
    Route::post('activation', [ProviderAuthController::class,'verifyAccount']);

    Route::post('project/store',[ProjectController::class,'store'])->middleware('auth:developer');
    Route::post('project/update/{id}',[ProjectController::class,'update'])->middleware('auth:developer');
    Route::get('project/show/{id}',[ProjectController::class,'show'])->middleware('auth:developer');
    Route::get('project/index',[ProjectController::class,'index'])->middleware('auth:developer');
    Route::get('project/delete/{id}',[ProjectController::class,'destroy'])->middleware('auth:developer');

    Route::post('profile/store',[ProfileController::class,'store'])->middleware('auth:developer');
    Route::post('profile/update/{id}',[ProfileController::class,'update'])->middleware('auth:developer');
    Route::get('profile/show/{id}',[ProfileController::class,'show'])->middleware('auth:developer');
    Route::get('profile/index',[ProfileController::class,'index'])->middleware('auth:developer');
    Route::get('profile/delete/{id}',[ProfileController::class,'destroy'])->middleware('auth:developer');
});

/*---------------------------------------------------------*/


Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers\Home',
    'prefix' => 'home'

], function ($router) {

    Route::get('blog/show/{id}',[HomeBlogController::class,'show']);
    Route::get('blog/index',[HomeBlogController::class,'index']);

    Route::get('category/show/{id}',[HomeCategoryController::class,'show']);
    Route::get('category/index',[HomeCategoryController::class,'index']);

    Route::get('subcategory/show/{id}',[HomeSubCategoryController::class,'show']);
    Route::get('subcategory/index',[HomeSubCategoryController::class,'index']);

    Route::get('slider/show/{id}',[HomeSliderController::class,'show']);
    Route::get('slider/index',[HomeSliderController::class,'index']);

    Route::get('provider/show/{id}',[HomeProviderController::class,'show']);
    Route::get('provider/index',[HomeProviderController::class,'index']);

    Route::get('project/show/{id}',[HomeProjectController::class,'show']);
    Route::get('project/index',[HomeProjectController::class,'index']);

    Route::get('search/{term}',[HomeSearchController::class,'search']);
});
