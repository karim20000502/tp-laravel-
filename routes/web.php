<?php

use App\Http\Controllers\StagiaireController;
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

// Route::get('/', function () {
//     return view('welcome');
// });




Route::get('/',[StagiaireController::class,'index']);
Route::post('/',[StagiaireController::class,'create']);
Route::get('create',[StagiaireController::class,'create']);
Route::post('create',[StagiaireController::class,'store']);
Route::get('show/{id}',[StagiaireController::class,'show']);
