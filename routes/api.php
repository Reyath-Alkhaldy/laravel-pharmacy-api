<?php

use App\Http\Controllers\Api\AccessTokensController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckOutController;
use App\Http\Controllers\Api\MainCategoryController;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\PharmacyController;
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
Route::apiResource('orders',  CheckOutController::class);
Route::apiResource('cart',  CartController::class);

Route::post('auth/access-tokens', [AccessTokensController::class,'store'])
->middleware('guest:sanctum')
->name('access-tokens');

Route::delete('auth/access-tokens/{token?}', [AccessTokensController::class,'destroy'])
->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('/medicines',function(){
//     return "hello";
// }  );
Route::apiResource('/medicines', MedicineController::class);
Route::apiResource('/main-categories', MainCategoryController::class);
Route::apiResource('/pharmacies', PharmacyController::class);