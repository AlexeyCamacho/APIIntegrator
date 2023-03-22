<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'view'])->name('admin.view');

        Route::prefix('role')->group(function () {
            Route::controller(RoleController::class)->group(function () {
                Route::get('/', 'get')->name('role.get');
                Route::get('/create', 'create')->name('role.create');
                Route::post('/', 'store')->name('role.store');
                Route::get('/{id}/edit', 'edit')->name('role.edit');
                Route::put('/{id}', 'update')->name('role.update');
                Route::delete('/{id}', 'destroy')->name('role.destroy');
            });
        });

        Route::prefix('user')->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('/', 'get')->name('user.get');
                Route::get('/create', 'create')->name('user.create');
                Route::post('/', 'store')->name('user.store');
                Route::get('/{id}/edit', 'edit')->name('user.edit');
                Route::put('/{id}', 'update')->name('user.update');
                Route::delete('/{id}', 'destroy')->name('user.destroy');
            });
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
