<?php

use App\Http\Controllers\Admin\ActualiteAdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategorieAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\DemoSeedAdminController;
use App\Http\Controllers\Admin\EditorUploadController;
use App\Http\Controllers\Admin\JoueurAdminController;
use App\Http\Controllers\Admin\JoueurPhotosSyncAdminController;
use App\Http\Controllers\Admin\MatchAdminController;
use App\Http\Controllers\Admin\MediaAdminController;
use App\Http\Controllers\Admin\PartenaireAdminController;
use App\Http\Controllers\Admin\PreInscriptionAdminController;
use App\Http\Controllers\Admin\RosterImportAdminController;
use App\Http\Controllers\Admin\StaffTechniqueAdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/admin/editor/upload', [EditorUploadController::class, 'store'])->name('admin.editor.upload');

    Route::get('/', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/demo-seed', [DemoSeedAdminController::class, 'store'])->name('admin.demo_seed');
    Route::post('/admin/roster-import', [RosterImportAdminController::class, 'store'])->name('admin.roster_import');
    Route::post('/admin/joueur-photos-sync', [JoueurPhotosSyncAdminController::class, 'store'])->name('admin.joueur_photos_sync');

    Route::prefix('admin')->group(function () {
        Route::get('/actualites', [ActualiteAdminController::class, 'index'])->name('admin.actualites.index');
        Route::post('/actualites/reorder', [ActualiteAdminController::class, 'reorder'])->name('admin.actualites.reorder');
        Route::get('/actualites/create', [ActualiteAdminController::class, 'create'])->name('admin.actualites.create');
        Route::post('/actualites', [ActualiteAdminController::class, 'store'])->name('admin.actualites.store');
        Route::get('/actualites/{actualite}/edit', [ActualiteAdminController::class, 'edit'])->name('admin.actualites.edit');
        Route::put('/actualites/{actualite}', [ActualiteAdminController::class, 'update'])->name('admin.actualites.update');
        Route::delete('/actualites/{actualite}', [ActualiteAdminController::class, 'destroy'])->name('admin.actualites.destroy');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/joueurs', [JoueurAdminController::class, 'index'])->name('admin.joueurs.index');
        Route::post('/joueurs/bulk-delete', [JoueurAdminController::class, 'bulkDestroy'])->name('admin.joueurs.bulk_destroy');
        Route::put('/joueurs/bulk-update', [JoueurAdminController::class, 'bulkUpdate'])->name('admin.joueurs.bulk_update');
        Route::post('/joueurs/bulk-photos', [JoueurAdminController::class, 'bulkPhotosEdit'])->name('admin.joueurs.bulk_photos.edit');
        Route::post('/joueurs/bulk-photos/save', [JoueurAdminController::class, 'bulkPhotosStore'])->name('admin.joueurs.bulk_photos.store');
        Route::post('/joueurs/reorder', [JoueurAdminController::class, 'reorder'])->name('admin.joueurs.reorder');
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

    Route::prefix('admin')->group(function () {
        Route::get('/media', [MediaAdminController::class, 'index'])->name('admin.media.index');
        Route::get('/media/create', [MediaAdminController::class, 'create'])->name('admin.media.create');
        Route::post('/media', [MediaAdminController::class, 'store'])->name('admin.media.store');
        Route::get('/media/{media}/edit', [MediaAdminController::class, 'edit'])->name('admin.media.edit');
        Route::put('/media/{media}', [MediaAdminController::class, 'update'])->name('admin.media.update');
        Route::delete('/media/{media}', [MediaAdminController::class, 'destroy'])->name('admin.media.destroy');
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategorieAdminController::class)->except(['show']);
    });

    Route::prefix('admin/matchs')->name('admin.matchs.')->group(function () {
        Route::get('/', [MatchAdminController::class, 'index'])->name('index');
        Route::get('/create', [MatchAdminController::class, 'create'])->name('create');
        Route::post('/', [MatchAdminController::class, 'store'])->name('store');
        Route::get('/{matchs}/edit', [MatchAdminController::class, 'edit'])->name('edit');
        Route::put('/{matchs}', [MatchAdminController::class, 'update'])->name('update');
        Route::delete('/{matchs}', [MatchAdminController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/partenaires')->name('admin.partenaires.')->group(function () {
        Route::get('/', [PartenaireAdminController::class, 'index'])->name('index');
        Route::post('/reorder', [PartenaireAdminController::class, 'reorder'])->name('reorder');
        Route::get('/create', [PartenaireAdminController::class, 'create'])->name('create');
        Route::post('/', [PartenaireAdminController::class, 'store'])->name('store');
        Route::get('/{partenaire}/edit', [PartenaireAdminController::class, 'edit'])->name('edit');
        Route::put('/{partenaire}', [PartenaireAdminController::class, 'update'])->name('update');
        Route::delete('/{partenaire}', [PartenaireAdminController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/pre-inscriptions')->name('admin.pre_inscriptions.')->group(function () {
        Route::get('/', [PreInscriptionAdminController::class, 'index'])->name('index');
        Route::get('/export', [PreInscriptionAdminController::class, 'export'])->name('export');
        Route::patch('/{preInscription}/toggle', [PreInscriptionAdminController::class, 'toggleTraite'])->name('toggle');
    });
});
