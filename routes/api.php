<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api', 
    'prefix' => 'auth'     
], function(){
    Route::post('login', [AuthController::class, 'login'])->name('login'); 
});

Route::group([
    'middleware' => 'api'
], function(){
// masukin kedalam array
    Route::resources([
        'categories' => CategoryController::class,
        'subcategories' => SubcategoryController::class,
        'sliders' => SliderController::class
    ]);
});