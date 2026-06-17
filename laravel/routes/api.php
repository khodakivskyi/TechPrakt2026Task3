<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;

Route::get('brands', [BrandController::class, 'getBrands']);
Route::get('brands/{id}', [BrandController::class, 'getBrand']);
Route::post('brands', [BrandController::class, 'createBrand']);
Route::patch('brands/{id}', [BrandController::class, 'updateBrand']);
Route::delete('brands/{id}', [BrandController::class, 'deleteBrand']);
