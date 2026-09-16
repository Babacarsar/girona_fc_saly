<?php

use App\Http\Controllers\API\ActualiteController;
use App\Http\Controllers\API\MatchController;
use App\Http\Controllers\API\MediaApiController;
use App\Http\Controllers\API\PartenaireController;
use App\Http\Controllers\API\PreInscriptionController;
use App\Http\Controllers\API\StaffTechniqueController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\JoueurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('joueurs', [JoueurController::class, 'index']);
Route::get('joueurs/{joueur}', [JoueurController::class, 'show']);

Route::apiResource('categories', CategorieController::class)->only(['index', 'show']);
Route::get('categories/{id}/joueurs', [CategorieController::class, 'joueurs']);

Route::apiResource('staff', StaffTechniqueController::class)->only(['index']);

Route::get('/actualites', [ActualiteController::class, 'index']);
Route::get('/actualites/{id}', [ActualiteController::class, 'show']);

Route::get('/media', [MediaApiController::class, 'index']);
Route::get('/media/{id}', [MediaApiController::class, 'show']);

Route::get('/matchs', [MatchController::class, 'index']);
Route::get('/partenaires', [PartenaireController::class, 'index']);

Route::post('/pre-inscriptions', [PreInscriptionController::class, 'store'])
    ->middleware('throttle:10,1');
