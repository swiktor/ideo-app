<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [CategoryController::class, 'index'])->name('manage');

Route::group([
    'prefix' => 'category',
    'as' => 'category.'
], function () {
    Route::post('store', [CategoryController::class, 'store'])->name('store');
    Route::delete('destroy', [CategoryController::class, 'destroy'])->name('destroy');
    Route::put('update', [CategoryController::class, 'update'])->name('update');
    Route::put('change', [CategoryController::class, 'change'])->name('change');
}
);



