<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;

// ── Public Routes ──────────────────────────

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang');
Route::get('/explore', [PageController::class, 'exploreIndex'])->name('explore.index');
Route::get('/explore/{category}', [PageController::class, 'exploreCategory'])->name('explore.category');
Route::get('/explore/{category}/{slug}', [PageController::class, 'exploreDetail'])->name('explore.detail');
Route::get('/berita', [PageController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{slug}', [PageController::class, 'beritaDetail']);

// ── Auth Routes ────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Admin Routes (Protected: auth + admin middleware) ──────

Route::middleware(['auth', 'admin'])->group(function () {

    // Admin Dashboard
    Route::get('/admin', [PageController::class, 'adminDashboard'])->name('admin.dashboard');

    // Admin API: Destinasi (Wisata Alam)
    Route::post('/admin/api/destinations', [App\Http\Controllers\AdminController::class, 'storeDestination']);
    Route::put('/admin/api/destinations/{id}', [App\Http\Controllers\AdminController::class, 'updateDestination']);
    Route::patch('/admin/api/destinations/{id}/toggle', [App\Http\Controllers\AdminController::class, 'toggleDestinationStatus']);
    Route::delete('/admin/api/destinations/{id}', [App\Http\Controllers\AdminController::class, 'destroyDestination']);

    // Admin API: Artikel
    Route::post('/admin/api/articles', [App\Http\Controllers\AdminController::class, 'storeArticle']);
    Route::put('/admin/api/articles/{id}', [App\Http\Controllers\AdminController::class, 'updateArticle']);
    Route::patch('/admin/api/articles/{id}/toggle', [App\Http\Controllers\AdminController::class, 'toggleArticleStatus']);
    Route::delete('/admin/api/articles/{id}', [App\Http\Controllers\AdminController::class, 'destroyArticle']);

    // Admin API: Kuliner
    Route::post('/admin/api/culinaries', [App\Http\Controllers\AdminController::class, 'storeCulinary']);
    Route::put('/admin/api/culinaries/{id}', [App\Http\Controllers\AdminController::class, 'updateCulinary']);
    Route::patch('/admin/api/culinaries/{id}/toggle', [App\Http\Controllers\AdminController::class, 'toggleCulinaryStatus']);
    Route::delete('/admin/api/culinaries/{id}', [App\Http\Controllers\AdminController::class, 'destroyCulinary']);

    // Admin API: Budaya
    Route::post('/admin/api/budaya', [App\Http\Controllers\AdminController::class, 'storeBudaya']);
    Route::put('/admin/api/budaya/{id}', [App\Http\Controllers\AdminController::class, 'updateBudaya']);
    Route::patch('/admin/api/budaya/{id}/toggle', [App\Http\Controllers\AdminController::class, 'toggleBudayaStatus']);
    Route::patch('/admin/api/budaya/{id}/featured', [App\Http\Controllers\AdminController::class, 'toggleBudayaFeatured']);
    Route::delete('/admin/api/budaya/{id}', [App\Http\Controllers\AdminController::class, 'destroyBudaya']);

    // Admin API: Sejarah
    Route::post('/admin/api/sejarah', [App\Http\Controllers\AdminController::class, 'storeSejarah']);
    Route::put('/admin/api/sejarah/{id}', [App\Http\Controllers\AdminController::class, 'updateSejarah']);
    Route::patch('/admin/api/sejarah/{id}/toggle', [App\Http\Controllers\AdminController::class, 'toggleSejarahStatus']);
    Route::patch('/admin/api/sejarah/{id}/featured', [App\Http\Controllers\AdminController::class, 'toggleSejarahFeatured']);
    Route::delete('/admin/api/sejarah/{id}', [App\Http\Controllers\AdminController::class, 'destroySejarah']);
});

