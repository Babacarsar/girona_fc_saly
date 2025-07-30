<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JoueurController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\API\StaffTechniqueController;
use App\Http\Controllers\API\ActualiteController;
use App\Http\Controllers\API\MediaApiController;

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
Route::apiResource('joueurs', JoueurController::class);
Route::apiResource('categories', CategorieController::class);
Route::get('categories/{id}/joueurs', [CategorieController::class, 'joueurs']);
Route::apiResource('staff', StaffTechniqueController::class)->only(['index']);



Route::get('/actualites', [ActualiteController::class, 'index']);
Route::get('/actualites/{id}', [ActualiteController::class, 'show']);



Route::get('/media', [MediaApiController::class, 'index']);
Route::get('/media/{id}', [MediaApiController::class, 'show']);



