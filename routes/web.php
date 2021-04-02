<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ContactController;
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

Route::get('/', function () {
    return view('welcome');
});
/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/
Route::get('/users', [UsersController::class, 'index'])->name('user.index');
Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('user.edit');
Route::post('/users/store/', [UsersController::class, 'store'])->name('user.store');
Route::get('/users/{id}', [UsersController::class, 'show'])->name('user.show');
Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('user.destroy');



/*
|--------------------------------------------------------------------------
| Contacts Routes
|--------------------------------------------------------------------------
*/
Route::get('/contacts/create/', [ContactController::class, 'create'])->name('contact.create');
Route::get('/contacts', [ContactController::class, 'index'])->name('contact.index');
Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contact.show');
Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])->name('contact.edit');
Route::post('/contacts/store/', [ContactController::class, 'store'])->name('contact.store');
Route::put('/contacts/{id}/update', [ContactController::class, 'update'])->name('contact.update');
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
