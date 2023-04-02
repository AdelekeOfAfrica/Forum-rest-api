<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\SubCategoriesController;


Route::prefix('admin')->group(function(){
     Route::post('/login', [AdminAuthController::class, 'login']);
     Route::post('/register', [AdminAuthController::class, 'register']);

     Route::middleware('auth:admin,api-admin')->group(function () { //the auth is from the guards created in the config->auth
           Route::resource('categories',CategoriesController::class);
           Route::resource('subcategories',SubCategoriesController::class);
           Route::post('/logout', [AdminAuthController::class, 'logout']);
     });
});

