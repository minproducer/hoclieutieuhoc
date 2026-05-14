<?php

use App\Http\Controllers\Admin\DriveController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::redirect('/login', '/admin/login')->name('login');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/mon/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/tai-lieu/{slug}', [DocumentController::class, 'show'])->name('document.show');
Route::get('/tai-lieu/{slug}/chuan-bi-tai', [DocumentController::class, 'downloadPage'])->name('document.download.page');
Route::get('/tai-lieu/{slug}/download', [DocumentController::class, 'download'])->name('document.download');

Route::get('/admin/drive/auth', [DriveController::class, 'auth'])
    ->name('admin.drive.auth')
    ->middleware('auth');

Route::get('/admin/drive/callback', [DriveController::class, 'callback'])
    ->name('admin.drive.callback');
