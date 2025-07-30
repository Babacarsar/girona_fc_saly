<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\JoueurAdminController;
use App\Http\Controllers\Admin\CategorieAdminController;
use App\Http\Controllers\Admin\StaffTechniqueAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\ActualiteAdminController;
use App\Http\Controllers\Admin\MediaAdminController;


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



Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
});

Route::prefix('admin')->group(function () {
    Route::get('/actualites', [ActualiteAdminController::class, 'index'])->name('admin.actualites.index');
    Route::get('/actualites/create', [ActualiteAdminController::class, 'create'])->name('admin.actualites.create');
    Route::post('/actualites', [ActualiteAdminController::class, 'store'])->name('admin.actualites.store');
    Route::get('/actualites/{actualite}/edit', [ActualiteAdminController::class, 'edit'])->name('admin.actualites.edit');
    Route::put('/actualites/{actualite}', [ActualiteAdminController::class, 'update'])->name('admin.actualites.update');
    Route::delete('/actualites/{actualite}', [ActualiteAdminController::class, 'destroy'])->name('admin.actualites.destroy');
});

Route::prefix('admin')->group(function () {
    Route::get('/joueurs', [JoueurAdminController::class, 'index'])->name('admin.joueurs.index');
    Route::get('/joueurs/create', [JoueurAdminController::class, 'create'])->name('admin.joueurs.create');
    Route::post('/joueurs', [JoueurAdminController::class, 'store'])->name('admin.joueurs.store');
    Route::get('/joueurs/{joueur}/edit', [JoueurAdminController::class, 'edit'])->name('admin.joueurs.edit');
    Route::put('/joueurs/{joueur}', [JoueurAdminController::class, 'update'])->name('admin.joueurs.update');
    Route::delete('/joueurs/{joueur}', [JoueurAdminController::class, 'destroy'])->name('admin.joueurs.destroy');
});



Route::prefix('admin')->group(function () {
    Route::get('/staff', [StaffTechniqueAdminController::class, 'index'])->name('admin.staff.index');
    Route::get('/staff/create', [StaffTechniqueAdminController::class, 'create'])->name('admin.staff.create');
    Route::post('/staff', [StaffTechniqueAdminController::class, 'store'])->name('admin.staff.store');
    Route::get('/staff/{staff}/edit', [StaffTechniqueAdminController::class, 'edit'])->name('admin.staff.edit');
    Route::put('/staff/{staff}', [StaffTechniqueAdminController::class, 'update'])->name('admin.staff.update');
    Route::delete('/staff/{staff}', [StaffTechniqueAdminController::class, 'destroy'])->name('admin.staff.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategorieAdminController::class);
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('media', MediaAdminController::class);
});



