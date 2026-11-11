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

/*
|--------------------------------------------------------------------------
| Application RH (Gestion des ressources humaines)
|--------------------------------------------------------------------------
*/
Route::prefix('rh')->name('rh.')->group(function () {
    Route::get('/', \App\Http\Controllers\RH\DashboardController::class)->name('dashboard');
    Route::resource('departements', \App\Http\Controllers\RH\DepartementController::class);
    Route::resource('employes', \App\Http\Controllers\RH\EmployeController::class)
        ->parameters(['employes' => 'employe']);
    Route::resource('conges', \App\Http\Controllers\RH\CongeController::class)
        ->only(['index', 'create', 'store', 'destroy'])
        ->parameters(['conges' => 'conge']);
    Route::patch('conges/{conge}/approuver', [\App\Http\Controllers\RH\CongeController::class, 'approuver'])->name('conges.approuver');
    Route::patch('conges/{conge}/refuser', [\App\Http\Controllers\RH\CongeController::class, 'refuser'])->name('conges.refuser');
});
