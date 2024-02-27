<?php

use App\Http\Controllers\Api\User\Auth\CreateNewUserController;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\CheckOutController;
use App\Http\Controllers\Api\User\ConsultationController;
use App\Http\Controllers\api\User\DoctorController;
use App\Http\Controllers\Api\User\FavoriteController;
use App\Http\Controllers\Api\User\MainCategoryController;
use App\Http\Controllers\Api\User\MedicineController;
use App\Http\Controllers\Api\User\PharmacyController;
use App\Http\Controllers\Api\User\SpecialtyController;
use App\Http\Controllers\Api\User\Auth\AccessTokensController;
use App\Http\Controllers\Api\User\Auth\EmailVerificationController;
use App\Http\Controllers\Api\User\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\User\Auth\ProfileController;
use App\Http\Controllers\Api\User\Auth\ResetPasswordController;
use App\Http\Controllers\Api\User\NotificationController;
use App\Http\Controllers\Api\User\UploadImageController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('users', function () {
    return User::all();
});

Route::apiResource('cart',  CartController::class);

Route::post('password/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('password/reset', [ResetPasswordController::class, 'resetPassword']);
// register
Route::post('register', [CreateNewUserController::class, 'create']);
// login
Route::post('auth/access-tokens', [AccessTokensController::class, 'store'])
    ->middleware('guest:sanctum')->name('access-tokens');

Route::middleware('auth:sanctum')->group(function () {
    // ! checkout or orders
    Route::apiResource('checkout',  CheckOutController::class);

    Route::delete('auth/access-tokens/{token?}', [AccessTokensController::class, 'destroy']);

    Route::get('/user', function (Request $request) {
        return $request->user();
        // return $request->user()->medicines;
    });

    Route::put('/user', [ProfileController::class, 'update']);
    Route::post('email-verification', [EmailVerificationController::class, 'emailVerification']);
    Route::get('email-verification', [EmailVerificationController::class, 'sendEmailVerification']);
});


//!     auth:sanctum 
Route::middleware('auth:sanctum')->group(function () {

    // ! Upload Image 
    Route::post('uploadImage', [UploadImageController::class, 'uploadImage']);

    //!  Api Routes
    Route::apiResource('/notifications', NotificationController::class);
    Route::get('/unreadNotifications', [NotificationController::class, 'unreadNotifications']);
    Route::get('/readNotifications', [NotificationController::class, 'readNotifications']);
    // ! consultaions 
    Route::apiResource('/consultaions', ConsultationController::class);
    Route::get('consultations/doctors', [ConsultationController::class, 'doctors']);
    Route::post('/marksRead', [ConsultationController::class, 'marksRead']);
    // Api favorites
    Route::delete('/favorites/remove',[FavoriteController::class,'remove']); 
    Route::apiResource('/favorites', FavoriteController::class);
});


Route::apiResource('/pharmacies', PharmacyController::class);
Route::apiResource('/main-categories', MainCategoryController::class);
Route::apiResource('/medicines', MedicineController::class); //->middleware(['auth:sanctum']);
Route::apiResource('/spicialties', SpecialtyController::class);
Route::apiResource('/doctors', DoctorController::class);


















// Route::prefix('spicialties')->group(function () {
//     Route::get('/',[ConsulationController::class,'spicialties']);
//     Route::get('doctors',[ConsulationController::class,'doctors']);
//     Route::get('consultaions',[ConsulationController::class,'consultaions']);
// });