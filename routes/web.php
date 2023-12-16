<?php

use App\Http\Controllers\Web\MainCategoryController;
use App\Http\Controllers\Web\SubCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    // 'middleware' => ['auth',"App\Http\Middleware\CheckUserType:admin,user"],
    // 'middleware' => ['auth:admin'],
    // 'middleware' => ['auth','auth.type:user,admin,super-admin'],
    'prefix'=>'/categories',
    'as'=>'web.'
    ],function(){
Route::resource('/main', MainCategoryController::class); 
Route::resource('/sub', SubCategoryController::class); 

});
