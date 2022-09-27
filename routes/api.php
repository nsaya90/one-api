<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Création de poste
// a mettre en place le middleware quand le module de connexion serait pret
Route::post('/addPost', [PostController::class, 'store'])->name('addPost.store');
// Modification d'un post
Route::put('/addPost/{id}', [PostController::class, 'update'])->name('addPost.update');
// Ajout de photo
Route::post('/addFile', [PostController::class, 'file'])->name('file.store');
