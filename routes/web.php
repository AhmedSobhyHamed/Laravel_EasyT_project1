<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
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

Route::get('/signup', [UserController::class , 'signup'])->name('signupRoute');
Route::get('/login', [UserController::class , 'login'])->name('loginRoute');
Route::post('authenticate',[UserController::class,'authenticate'])->name('authenticateRoute');
Route::get('/blog', [BlogController::class,'index'])->name('blogRoute');
Route::get('/blogpost/{id}',[BlogController::class,'show'])->name('blogpost')->where('id','[0-9]+');
Route::get('/blog/create/new',[BlogController::class,'create'])->name('blogcreateui');
Route::post('/blog/createblog',[BlogController::class,'store'])->name('createblog');

