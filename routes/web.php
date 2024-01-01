<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\TechnicalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/technicals', [TechnicalController::class, 'index'])->name('technicals.index');
    Route::get('/technicals/download/{technical}', [TechnicalController::class, 'downloadFile'])->name('technicals.downloadFile');
    Route::get('/technicals/{technical}', [TechnicalController::class, 'show'])->name('technicals.show');
    Route::post('/technicals', [TechnicalController::class, 'store'])->name('technicals.store');
    Route::put('/technicals', [TechnicalController::class, 'update'])->name('technicals.update');
    Route::delete('/technicals/{technical}', [TechnicalController::class, 'destroy'])->name('technicals.destroy');
    Route::post('/technicals/change/{technical}', [TechnicalController::class, 'changeStatus'])->name('technicals.changeStatus');

    Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
    Route::get('/stories/{story}', [StoryController::class, 'show'])->name('stories.show');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
    Route::put('/stories', [StoryController::class, 'update'])->name('stories.update');
    Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/export', [CategoryController::class, 'export'])->name('categories.export');
    Route::post('/categories/import', [CategoryController::class, 'import'])->name('categories.import');

    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::put('/accounts', [AccountController::class, 'update'])->name('accounts.update');
    Route::delete('/accounts/{user}', [AccountController::class, 'destroy'])->name('accounts.destroy');
    Route::put('/accounts/password', [AccountController::class, 'updatePassword'])->name('accounts.password');

    Route::get('/role-management', [RoleManagementController::class, 'index'])->name('role-management.index');

    Route::get('/history/technical', [HistoryController::class, 'indexTechnical'])->name('history.technical');
    Route::get('/history/story', [HistoryController::class, 'indexStory'])->name('history.story');
    Route::get('/history/category', [HistoryController::class, 'indexCategory'])->name('history.category');
    Route::get('/history/etc', [HistoryController::class, 'indexEtc'])->name('history.etc');
});

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/', function () {
        return view('landing');
    })->name('landing');
});