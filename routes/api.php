<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\PostController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Création d'une route pour se connecter/déconnecter

Route::post('/login', [Controller::class, 'login'])->name("user.login");
Route::middleware('auth:sanctum')->get('/logout', [Controller::class, 'logout'])->name("logout.logout");

// Création de 4 routes USER pour la méthode CRUD

Route::post('/register', [Controller::class, 'register'])->name("user.register");
Route::middleware('auth:sanctum')->get('/user', [Controller::class, 'profile'])->name("user.profile");
Route::middleware('auth:sanctum')->put('/user', [Controller::class, 'update'])->name("user.update");
Route::middleware('auth:sanctum')->delete('/user', [Controller::class, 'destroy'])->name("user.destroy");
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Création de poste
// a mettre en place le middleware quand le module de connexion serait pret
Route::middleware('auth:sanctum')->post('/addPost', [PostController::class, 'store'])->name('addPost.store');
Route::middleware('auth:sanctum')->get('/addPost', [PostController::class, 'index'])->name('addPost.index');
Route::put('/addPost/{id}', [PostController::class, 'refresh'])->name('addPost.refresh');
Route::middleware('auth:sanctum')->get('/addPost/{id}', [PostController::class, 'showPost']);

// Ajout de photo
Route::post('/addFile', [PostController::class, 'file'])->name('file.store');
