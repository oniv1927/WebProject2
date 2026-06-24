<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// Home (Beranda)
Route::get('/', [PageController::class, 'home'])->name('home');

// Tentang
Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang');

// Explore Hub
Route::get('/explore', [PageController::class, 'exploreIndex'])->name('explore.index');

// Explore Category (wisata-alam, kuliner, budaya, sejarah)
Route::get('/explore/{category}', [PageController::class, 'exploreCategory'])->name('explore.category');

// Explore Detail
Route::get('/explore/{category}/{slug}', [PageController::class, 'exploreDetail'])->name('explore.detail');

// Berita (News)
Route::get('/berita', [PageController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{slug}', [PageController::class, 'beritaDetail']);

// Admin routes (without auth for now based on user's reply)
Route::get('/admin', [PageController::class, 'adminDashboard'])->name('admin.dashboard');

// Admin API routes for AJAX
Route::post('/admin/api/destinations', [App\Http\Controllers\AdminController::class, 'storeDestination']);
Route::put('/admin/api/destinations/{id}', [App\Http\Controllers\AdminController::class, 'updateDestination']);
Route::patch('/admin/api/destinations/{id}/toggle', [App\Http\Controllers\AdminController::class, 'toggleDestinationStatus']);
Route::delete('/admin/api/destinations/{id}', [App\Http\Controllers\AdminController::class, 'destroyDestination']);

Route::post('/admin/api/articles', [App\Http\Controllers\AdminController::class, 'storeArticle']);
Route::put('/admin/api/articles/{id}', [App\Http\Controllers\AdminController::class, 'updateArticle']);
Route::patch('/admin/api/articles/{id}/toggle', [App\Http\Controllers\AdminController::class, 'toggleArticleStatus']);
Route::delete('/admin/api/articles/{id}', [App\Http\Controllers\AdminController::class, 'destroyArticle']);

Route::post('/admin/api/culinaries', [App\Http\Controllers\AdminController::class, 'storeCulinary']);
Route::put('/admin/api/culinaries/{id}', [App\Http\Controllers\AdminController::class, 'updateCulinary']);
Route::patch('/admin/api/culinaries/{id}/toggle', [App\Http\Controllers\AdminController::class, 'toggleCulinaryStatus']);
Route::delete('/admin/api/culinaries/{id}', [App\Http\Controllers\AdminController::class, 'destroyCulinary']);

// Admin: Budaya (Destinations with category=budaya)
Route::post('/admin/api/budaya', [App\Http\Controllers\AdminController::class, 'storeBudaya']);
Route::put('/admin/api/budaya/{id}', [App\Http\Controllers\AdminController::class, 'updateBudaya']);
Route::patch('/admin/api/budaya/{id}/toggle', [App\Http\Controllers\AdminController::class, 'toggleBudayaStatus']);
Route::patch('/admin/api/budaya/{id}/featured', [App\Http\Controllers\AdminController::class, 'toggleBudayaFeatured']);
Route::delete('/admin/api/budaya/{id}', [App\Http\Controllers\AdminController::class, 'destroyBudaya']);

// Admin: Sejarah (Destinations with category=sejarah)
Route::post('/admin/api/sejarah', [App\Http\Controllers\AdminController::class, 'storeSejarah']);
Route::put('/admin/api/sejarah/{id}', [App\Http\Controllers\AdminController::class, 'updateSejarah']);
Route::patch('/admin/api/sejarah/{id}/toggle', [App\Http\Controllers\AdminController::class, 'toggleSejarahStatus']);
Route::patch('/admin/api/sejarah/{id}/featured', [App\Http\Controllers\AdminController::class, 'toggleSejarahFeatured']);
Route::delete('/admin/api/sejarah/{id}', [App\Http\Controllers\AdminController::class, 'destroySejarah']);
