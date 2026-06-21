<?php

use App\Http\Controllers\Admin\HikeAdminController;
use App\Http\Controllers\Admin\HikeDraftAdminController;
use App\Http\Controllers\Admin\RegionAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\HikeController;
use App\Http\Controllers\HikeDraftController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegionController::class, 'index'])->name('regions.index');
Route::get('/regions/{region}', [RegionController::class, 'show'])->name('regions.show');
Route::get('/hikes', [HikeController::class, 'index'])->name('hikes.index');
Route::get('/hikes/{hike}', [HikeController::class, 'show'])->name('hikes.show');

Route::middleware(['auth', 'is_not_banned'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/drafts/create', [HikeDraftController::class, 'create'])->name('drafts.create');
    Route::post('/drafts', [HikeDraftController::class, 'store'])->name('drafts.store');

    Route::post('/hikes/{hike}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::middleware(['auth', 'is_not_banned', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('regions', RegionAdminController::class)->except(['show']);
    Route::resource('hikes', HikeAdminController::class)->except(['show']);
    Route::get('drafts', [HikeDraftAdminController::class, 'index'])->name('drafts.index');
    Route::get('drafts/{draft}', [HikeDraftAdminController::class, 'show'])->name('drafts.show');
    Route::patch('drafts/{draft}/bind-region', [HikeDraftAdminController::class, 'bindRegion'])->name('drafts.bindRegion');
    Route::delete('drafts/{draft}', [HikeDraftAdminController::class, 'destroy'])->name('drafts.destroy');
    Route::get('users', [UserAdminController::class, 'index'])->name('users.index');
    Route::patch('users/{user}/ban', [UserAdminController::class, 'ban'])->name('users.ban');
    Route::patch('users/{user}/unban', [UserAdminController::class, 'unban'])->name('users.unban');
});

require __DIR__.'/auth.php';
