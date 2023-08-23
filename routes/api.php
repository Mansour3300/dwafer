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
use App\Http\Controllers\Provider\ServiceController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Client\ClientChatController;
use App\Http\Controllers\Home\HomeCategoryController;
use App\Http\Controllers\Home\HomeProviderController;
use App\Http\Controllers\Home\HomeSubCategoryController;
use App\Http\Controllers\Client\RequestServiceController;
use App\Http\Controllers\Provider\ProviderAuthController;
use App\Http\Controllers\Provider\ProviderChatController;

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

    'middleware' => ['api','checklang'],
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

    Route::post('request/store',[RequestServiceController::class,'store'])->middleware('auth');
    Route::post('request/update/{id}',[RequestServiceController::class,'update'])->middleware('auth');
    Route::get('request/show/{id}',[RequestServiceController::class,'show'])->middleware('auth');
    Route::get('request/index',[RequestServiceController::class,'index'])->middleware('auth');  //اعرضه من غير
    Route::get('request/delete/{id}',[RequestServiceController::class,'destroy'])->middleware('auth');

    Route::post('chat/store',[ClientChatController::class,'store'])->middleware('auth');
    Route::get('chat/show/{id}',[ClientChatController::class,'show'])->middleware('auth');
    Route::get('chat/index',[ClientChatController::class,'index'])->middleware('auth');
    Route::get('chat/delete/{id}',[ClientChatController::class,'destroy'])->middleware('auth');

});


/*-------------------------------------------------------*/

Route::group([

    'middleware' => ['api' , 'checklang'],/**'checkadmin'*/
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'admin'

], function ($router) {

    Route::post('country/store',[CountryController::class,'store'])->middleware('checkadmin','auth');
    Route::post('country/update/{id}',[CountryController::class,'update'])->middleware('checkadmin','auth');
    Route::get('country/show/{id}',[CountryController::class,'show']);
    Route::get('country/index',[CountryController::class,'index']);  //اعرضه من غير
    Route::get('country/delete/{id}',[CountryController::class,'destroy'])->middleware('checkadmin','auth');

    Route::post('login', [AdminAuthController::class,'login'])->middleware('checkactivation');
    Route::get('logout', [AdminAuthController::class,'logout']);
    Route::post('register', [AdminAuthController::class,'adminRegister']);
    Route::post('forgotpass', [AdminAuthController::class,'forgot']);
    Route::post('resetcode', [AdminAuthController::class,'resetcode']);
    Route::post('reset', [AdminAuthController::class,'resetpass']);
    Route::post('activation', [AdminAuthController::class,'verifyAccount']);
    Route::get('delete/{id}', [AdminAuthController::class,'destroy'])->middleware('checksuperadmin','auth');

    Route::post('blog/store',[BlogController::class,'store'])->middleware('checkadmin','auth');
    Route::post('blog/update/{id}',[BlogController::class,'update'])->middleware('checkadmin','auth');
    Route::get('blog/show/{id}',[BlogController::class,'show'])->middleware('checkadmin','auth');
    Route::get('blog/index',[BlogController::class,'index'])->middleware('checkadmin','auth');
    Route::get('blog/delete/{id}',[BlogController::class,'destroy'])->middleware('checkadmin','auth');

    Route::post('category/store',[CategoryController::class,'store'])->middleware('checkadmin','auth');
    Route::post('category/update/{id}',[CategoryController::class,'update'])->middleware('checkadmin','auth');
    Route::get('category/show/{id}',[CategoryController::class,'show'])->middleware('checkadmin','auth');
    Route::get('category/index',[CategoryController::class,'index'])->middleware('checkadmin','auth');
    Route::get('category/delete/{id}',[CategoryController::class,'destroy'])->middleware('checkadmin','auth');

    Route::post('subcategory/store',[SubCategoryController::class,'store'])->middleware('checkadmin','auth');
    Route::post('subcategory/update/{id}',[SubCategoryController::class,'update'])->middleware('checkadmin','auth');
    Route::get('subcategory/show/{id}',[SubCategoryController::class,'show'])->middleware('checkadmin','auth');
    Route::get('subcategory/index',[SubCategoryController::class,'index'])->middleware('checkadmin','auth');
    Route::get('subcategory/delete/{id}',[SubCategoryController::class,'destroy'])->middleware('checkadmin','auth');

    Route::post('slider/store',[SliderController::class,'store'])->middleware('checkadmin','auth');
    Route::post('slider/update/{id}',[SliderController::class,'update'])->middleware('checkadmin','auth');
    Route::get('slider/show/{id}',[SliderController::class,'show'])->middleware('checkadmin','auth');
    Route::get('slider/index',[SliderController::class,'index'])->middleware('checkadmin','auth');
    Route::get('slider/delete/{id}',[SliderController::class,'destroy'])->middleware('checkadmin','auth');


});

/*---------------------------------------------------*/

Route::group([

    'middleware' => ['api','checklang'],/*,auth:developer*/
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

    Route::post('request/pick/{id}',[ServiceController::class,'pickService'])->middleware('auth:developer');
    Route::post('request/accept/{id}',[ServiceController::class,'acceptService'])->middleware('auth:developer');
    Route::get('request/show/{id}',[ServiceController::class,'show'])->middleware('auth:developer');
    Route::get('request/index',[ServiceController::class,'index'])->middleware('auth:developer');
    Route::post('request/refuse/{id}',[ServiceController::class,'refuseService'])->middleware('auth:developer');
    Route::get('request/mywork',[ServiceController::class,'myWork'])->middleware('auth:developer');

    Route::post('chat/store',[ProviderChatController::class,'store'])->middleware('auth:developer');
    Route::get('chat/show/{id}',[ProviderChatController::class,'show'])->middleware('auth:developer');
    Route::get('chat/index',[ProviderChatController::class,'index'])->middleware('auth:developer');
    Route::get('chat/delete/{id}',[ProviderChatController::class,'destroy'])->middleware('auth:developer');
});

/*---------------------------------------------------------*/


Route::group([

    'middleware' => ['api','checklang'],
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
