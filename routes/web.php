<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\MainCategoryController;
use App\Http\Controllers\Web\SubCategoryController;
// use Illuminate\Support\Facades\Route;

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
    return view('sidebars.index');
});
// Route::get('/if', function () {
//     return " hello";
// })->middleware(['guest']);
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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
