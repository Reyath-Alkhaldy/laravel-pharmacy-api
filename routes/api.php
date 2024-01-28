<?php

use App\Http\Controllers\Api\AccessTokensController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
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

Route::get('users', function () {
    return User::all();
});
Route::get('admins', function () {
    return Admin::all();
});
Route::apiResource('orders',  CheckOutController::class);
Route::apiResource('cart',  CartController::class);

Route::post('password/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('password/reset', [ResetPasswordController::class, 'resetPassword']);
// register
Route::post('register', [CreateNewUserController::class, 'create']);
// login
Route::post('auth/access-tokens', [AccessTokensController::class, 'store'])
    ->middleware('guest:sanctum')->name('access-tokens');

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('auth/access-tokens/{token?}', [AccessTokensController::class, 'destroy']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::put('/user',[ProfileController::class,'update']);
    Route::post('email-verification', [EmailVerificationController::class, 'emailVerification']);
    Route::get('email-verification', [EmailVerificationController::class, 'sendEmailVerification']);
});





//!  Api Routes
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