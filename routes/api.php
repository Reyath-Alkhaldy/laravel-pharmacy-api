<?php

use App\Http\Controllers\Api\AccessTokensController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckOutController;
use App\Http\Controllers\Api\ConsulationController;
use App\Http\Controllers\Api\CreateNewUserController;
use App\Http\Controllers\api\DoctorController;
use App\Http\Controllers\Api\MainCategoryController;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\PharmacyController;
use App\Http\Controllers\Api\SpecialtyController;
use App\Models\Admin;
use App\Models\User;
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
Route::get('users',function(){
    return User::all();
});
Route::get('admins',function(){
    return Admin::all();
});
Route::apiResource('orders',  CheckOutController::class);
Route::apiResource('cart',  CartController::class);

Route::post('auth/access-tokens', [AccessTokensController::class,'store'])
->middleware('guest:sanctum');
// ->name('access-tokens');

Route::delete('auth/access-tokens/{token?}', [AccessTokensController::class,'destroy'])
->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register',[CreateNewUserController::class,'create']);
Route::apiResource('/medicines', MedicineController::class);
Route::apiResource('/main-categories', MainCategoryController::class);
Route::apiResource('/pharmacies', PharmacyController::class);
Route::apiResource('/spicialties', SpecialtyController::class);
Route::apiResource('/doctors', DoctorController::class);
Route::apiResource('/consultaions', ConsulationController::class);

// Route::prefix('spicialties')->group(function () {
//     Route::get('/',[ConsulationController::class,'spicialties']);
//     Route::get('doctors',[ConsulationController::class,'doctors']);
//     Route::get('consultaions',[ConsulationController::class,'consultaions']);
// });