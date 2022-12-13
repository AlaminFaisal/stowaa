<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\RolePermissionController;
use App\Http\Controllers\Backend\SizeController;
use App\Http\Controllers\Frontend\FrontendController;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserAuth\UserAuthController;
use App\Models\User;
use Spatie\Permission\Models\Permission;


Auth::routes(['verify' => true]);


// Frontend routes 

Route::controller(FrontendController::class)->name('frontend.')->group(function(){
    Route::get('/', 'frontendIndex')->name('home');
});



//backend routs
Route::prefix('dashboard')->name('backend.')->group(function(){
    Route::get('/', [BackendController::class, 'dashboardIndex'])->middleware('verified')->name('home');

    //role and permission manage route
    Route::controller(RolePermissionController::class)->prefix('role')->name('role.')->group( function () {
        Route::get('/','indexRole')->name('index')->middleware(['role_or_permission:super-admin|see role']);
        Route::get('/create',  'createRole')->name('create')->middleware(['role_or_permission:super-admin|create role']);
        Route::post('/store', 'storeRole')->name('store')->middleware(['role_or_permission:super-admin|create role']);
        Route::get('/edit/{id}',  'editRole')->name('edit')->middleware(['role_or_permission:super-admin|edit role']);
        Route::post('/update/{id}', 'updateRole')->name('update')->middleware(['role_or_permission:super-admin|edit role']);
    
        Route::post('/permission/store',  'permissionStore')->name('permission.store');
    });

    //category route
    Route::controller(CategoryController::class)->prefix('category')->name('category.')->group( function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{category}/show/', 'shoe')->name('show');
        Route::get('/{category}/edit/', 'edit')->name('edit');
        Route::put('/{category}/update/', 'update')->name('update');
        Route::delete('/{category}/delete/', 'destroy')->name('destroy');
    });

    //Color route
    Route::controller(ColorController::class)->prefix('color')->name('color.')->group( function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{color}/show/', 'shoe')->name('show');
        Route::get('/{color}/edit/', 'edit')->name('edit');
        Route::put('/{color}/update/', 'update')->name('update');
        Route::delete('/{color}/delete/', 'destroy')->name('destroy');
    });
    
    //size route
    Route::controller(SizeController::class)->prefix('size')->name('size.')->group( function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{size}/show/', 'shoe')->name('show');
        Route::get('/{size}/edit/', 'edit')->name('edit');
        Route::put('/{size}/update/', 'update')->name('update');
        Route::delete('/{size}/delete/', 'destroy')->name('destroy');
    });

    //products route
    Route::controller(ProductController::class)->prefix('product')->name('product.')->group( function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{product}/show/', 'shoe')->name('show');
        Route::get('/{product}/edit/', 'edit')->name('edit');
        Route::put('/{product}/update/', 'update')->name('update');
        Route::delete('/{product}/delete/', 'destroy')->name('destroy');
    });
   
});


// user auth route

Route::get('/user/login', [UserAuthController::class, "login"])->name('user.login');
Route::get('/user/sign-up', [UserAuthController::class, "registation"])->name('user.registation');


// Route::get( '/test', function(){
//     return User::all()->random()->id;
// });