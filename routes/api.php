<?php

use App\Http\Controllers\back\AuthenticationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PackageController;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'company', 'middleware' => 'jwt'], function () {
    Route::post('/create', [CompanyController::class, 'store'])->name('company.create');
    Route::put('/update/{id}', [CompanyController::class, 'update'])->name('company.update');
    Route::get('/list', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/edit/{id}',[CompanyController::class,'edit'])->name('company.edit');
    Route::delete('/delete/{id}',[CompanyController::class,'destroy'])->name('company.destroy');
   
});
Route::middleware('jwt')->group(function () {
    Route::apiResource('packages', PackageController::class);
});

Route::post('login',[AuthenticationController::class,'login']);
Route::get('login',[AuthenticationController::class,'login']);

Route::middleware('jwt')->get('dashboard',[AuthenticationController::class,'show']);



