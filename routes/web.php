<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AboutController;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\About;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Routing\RouteGroup;

//use DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $brands = Brand::all();
    $sliders = Slider::all();
    $about = About::first();
    return view('frontend/home',compact('brands','sliders','about'));
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {

        //eloquent orm
        //$users = User::all();

        // query builder
        //$users = DB::table("users")->get();
        return view('admin.index');
    })->name('dashboard');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


// for category
Route::prefix('category')->middleware(['auth'])->group(function(){
    Route::get('/all',[CategoryController::class, 'allCat'])->name('all.category');
    Route::post('/add',[CategoryController::class, 'addCat'])->name('store.category');
    Route::get('/edit/{id}',[CategoryController::class, 'editCat']);
    Route::post('/update/{id}',[CategoryController::class, 'UpdateCat']);
    Route::get('/softdelete/{id}',[CategoryController::class, 'softDelete']);
    Route::get('/restore/{id}',[CategoryController::class, 'restoreCat']);
    Route::post('/delete/{id}',[CategoryController::class, 'deleteCat']);
});


// for brand
Route::prefix('brand')->middleware(['auth'])->group(function(){
    Route::get('/all',[BrandController::class, 'allBrand'])->name('all.brand');
    Route::post('/add',[BrandController::class, 'addBrand'])->name('store.brand');
    Route::get('/edit/{id}',[BrandController::class, 'editBrand']);
    Route::post('/update/{id}',[BrandController::class, 'updateBrand']);
    Route::post('/delete/{id}',[BrandController::class, 'deleteBrand']);
});


// for slider
Route::prefix('slider')->middleware(['auth'])->group(function(){
    Route::get('/all',[SliderController::class, 'allSlider'])->name('all.slider');
    Route::get('/create',[SliderController::class, 'createSlider'])->name('create.slider');
    Route::post('/store',[SliderController::class, 'storeSlider'])->name('store.slider');
});

// for about
Route::prefix('about')->middleware(['auth'])->group(function(){
    Route::get('/',[AboutController::class, 'indexAbout'])->name('index.about');
    Route::post('/update/{id}',[AboutController::class, 'updateAbout']);
});



Route::get('/user/logout',[BrandController::class, 'logout'])->name('user.logout');
