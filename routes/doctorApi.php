<?php

use App\Http\Controllers\Api\Doctor\Auth\AccessTokensDoctorController;
use App\Http\Controllers\Api\Doctor\Auth\CreateNewDoctorController;
use App\Http\Controllers\Api\Doctor\Auth\EmailVerificationDoctorController;
use App\Http\Controllers\Api\Doctor\Auth\ForgotPasswordDoctorController;
use App\Http\Controllers\Api\Doctor\Auth\ProfileDoctorController;
use App\Http\Controllers\Api\Doctor\Auth\ResetPasswordDoctorController;
use App\Http\Controllers\Api\Doctor\ConsultationDoctorController;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('/doctor')->group(function () {

    Route::get('doctors', function () {
        return Doctor::all();
    });

    Route::post('password/forgot-password', [ForgotPasswordDoctorController::class, 'forgotPassword']);
    Route::post('password/reset', [ResetPasswordDoctorController::class, 'resetPassword']);
   
    //! specialties
    Route::get('specialties', [CreateNewDoctorController::class, 'specialties']);
    // register
    Route::post('register', [CreateNewDoctorController::class, 'create']);
    // login
    Route::post('auth/access-tokens', [AccessTokensDoctorController::class, 'store'])
        ->middleware('guest:sanctum')->name('access-tokens');

    Route::middleware('auth:sanctum')->group(function () {
        Route::delete('auth/access-tokens/{token?}', [AccessTokensDoctorController::class, 'destroy']);
        Route::get('/doctor', function (Request $request) {
            return Auth::user();
            // return $request->user();
        });
        Route::put('/user', [ProfileDoctorController::class, 'update']);
        Route::post('email-verification', [EmailVerificationDoctorController::class, 'emailVerification']);
        Route::get('email-verification', [EmailVerificationDoctorController::class, 'sendEmailVerification']);
    });


    //!     auth:sanctum 
    Route::middleware('auth:sanctum')->group(function () {

    //!  Api Routes
    Route::apiResource('/consultaions', ConsultationDoctorController::class);
    Route::get('/consultations/users',[ConsultationDoctorController::class,'users']);

    });



});
