<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MainController;
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

Route::middleware('auth')->group(function () {
    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [MainController::class, 'show'])->name('dashboard');

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



require __DIR__.'/auth.php';
