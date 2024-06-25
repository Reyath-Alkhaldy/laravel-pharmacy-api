<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FirbaseController; 

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
Route::get("idnex", [FirbaseController::class,'idnex']);

// Route::get('firebase', function() {
//     return 'hi';
// });

// require __DIR__.'./pharmacyApi.php';
// require __DIR__.'/doctorApi.php';
// require __DIR__.'/userApi.php';
