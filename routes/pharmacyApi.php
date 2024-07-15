<?php

use App\Http\Controllers\Api\Pharmacy\Auth\AccessTokensPharmacyController;
use App\Http\Controllers\Api\Pharmacy\Auth\CreateNewPharmacyController;
use App\Http\Controllers\Api\Pharmacy\Auth\EmailVerificationPharmacyController;
use App\Http\Controllers\Api\Pharmacy\Auth\ForgotPasswordPharmacyController;
use App\Http\Controllers\Api\Pharmacy\Auth\ProfilePharmacyController;
use App\Http\Controllers\Api\Pharmacy\Auth\ResetPasswordPharmacyController;
use App\Http\Controllers\Api\Pharmacy\MainAndSubCategoryController;
use App\Http\Controllers\Api\Pharmacy\MainCategoryController;
use App\Http\Controllers\Api\Pharmacy\MedicineController;
use App\Http\Controllers\Api\Pharmacy\MostSellingMedicinesController;
use App\Http\Controllers\Api\Pharmacy\SubCategoryController;
// use App\Http\Controllers\Web\;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('/pharmacy')->group(function () {

    Route::get('pharmacies', function () {
        return response()->json([
            'data' => Pharmacy::all(),
        ]);
    });

    Route::post('password/forgot-password', [ForgotPasswordPharmacyController::class, 'forgotPassword']);
    Route::post('password/reset', [ResetPasswordPharmacyController::class, 'resetPassword']);

    //! specialties
    Route::get('specialties', [CreateNewPharmacyController::class, 'specialties']);
    // register
    Route::post('register', [CreateNewPharmacyController::class, 'create']);
    // login
    Route::post('auth/access-tokens', [AccessTokensPharmacyController::class, 'store'])
        ->middleware('guest:sanctum')->name('access-tokens');

    Route::middleware('auth:sanctum')->group(function () {
        Route::delete('auth/access-tokens/{token?}', [AccessTokensPharmacyController::class, 'destroy']);
        Route::get('/pharmacy', function (Request $request) {
            return Auth::user();
        });
        Route::put('/pharma', [ProfilePharmacyController::class, 'update']);
        Route::post('email-verification', [EmailVerificationPharmacyController::class, 'emailVerification']);
        Route::get('email-verification', [EmailVerificationPharmacyController::class, 'sendEmailVerification']);
    });


    //!     auth:sanctum 
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('mainCategories', [MainAndSubCategoryController::class, 'mainCategories']);
        Route::get('subCategories', [MainAndSubCategoryController::class, 'subCategories']);
        Route::apiResource('main-categories', MainCategoryController::class);
        Route::apiResource('sub-categories', SubCategoryController::class);
        Route::apiResource('medicines',  MedicineController::class);
    });
    Route::get('mostSellingMedicines', [MostSellingMedicinesController::class, 'mostSellingMedicines']);
});
