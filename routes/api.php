<?php

use App\Http\Controllers\Api\FirebaseNotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FirbaseController;
use App\Http\Controllers\Api\Pharmacy\Auth\AccessTokensPharmacyController;

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
// routes/web.php



Route::get("index", [FirbaseController::class,'index']);

Route::get('firebase', [FirbaseController::class,'firebase']);
Route::prefix('/pharmacy')->group(function () {
    Route::post('/firebase-send-notification', [FirebaseNotificationController::class, 'sendNotification']);

// Route::post('auth/access-tokens', [AccessTokensPharmacyController::class, 'store'])
// ->middleware('guest:sanctum')->name('access-tokens');
});
// require __DIR__.'./pharmacyApi.php';
// require __DIR__.'/doctorApi.php';
// require __DIR__.'/userApi.php';
