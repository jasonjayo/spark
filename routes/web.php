<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth', 'update_last_active'])->group(function () {
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get("/search", [ProfileController::class, "index"])->middleware(['auth'])->name('search');
    Route::get('/viewprofile/{id}', [ProfileController::class, 'show'])->name('viewprofile');
    Route::get("chat", [MessageController::class, "index"])->name("chat");
});

require __DIR__ . '/auth.php';
