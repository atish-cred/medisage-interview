<?php

use App\Http\Controllers\StudentController;
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

Route::get('/{search?}', [StudentController::class, 'index'])->name('/');
Route::get('/student/add/{id?}', [StudentController::class, 'add'])->name('/student/add');
Route::post('/student/save', [StudentController::class, 'save'])->name('/student/save');
Route::get('/student/delete/{id?}', [StudentController::class, 'destroy'])->name('/student/delete');

// Route::get('/', function () {
//     return view('welcome');
// });
