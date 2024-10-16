<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
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

Route::resource('test', ApiController::class);
Route::get('/', function () {
    return view('welcome');
});
Route::get('/check',function(){
    return view('check');
})->middleware('checkrouter')->name('check');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['checkrouter', 'verified'])->name('dashboard');

Route::middleware('checkrouter')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/categories',CategoriesController::class);
    Route::resource('/products',ProductsController::class);
});

require __DIR__.'/auth.php';
