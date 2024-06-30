<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\RecommendationController;
use App\Http\Middleware\EnsureAdmin;
use App\Models\Recommendation;
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
})->name("welcome");



Route::middleware(['auth', 'ensure_not_banned', 'update_last_active'])->group(function () {

    // admin only
    Route::middleware(['ensure_admin'])->group(function () {
        Route::post("ban", [AdminController::class, "ban"])->name("ban.create");
        Route::post("closeReport", [AdminController::class, "closeReport"])->name("report.close");
        Route::post("revokeBan", [AdminController::class, "revokeBan"])->name("ban.revoke");
        Route::get("/admin", [AdminController::class, "dashboard"])->name("admin");
        Route::delete("/deleteUserAccount", [AdminController::class, "deleteUserAccount"])->name("deleteUserAccount");

        Route::get("/admin/updateUserAccount/{id}", [AdminController::class, "updateUserAccount"])->name("updateUserAccount");

        Route::get("/admin/bans", [AdminController::class, "bansIndex"])->name("admin.bans");
        Route::get("/admin/reports", [AdminController::class, "reportsIndex"])->name("admin.reports");
    });

    // user only
    Route::middleware(['ensure_not_admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get("recommendations", [RecommendationController::class, "generate"]);

        // discovery queue
        Route::get("discovery", [RecommendationController::class, "index"])->name("discovery");
        Route::post("react", [RecommendationController::class, "react"])->name("react");

        Route::delete("match", [RecommendationController::class, "deleteMatch"])->name("deleteMatch");

        // ai suggestions
        Route::get("/aiSuggestions/{id}", [ChatController::class, "getAISuggestions"])->name("aiSuggestions");
    });

    // the post here either creates a new Profile entry on DB or Photo entry on DB depending on the name of the submit button passed in the post request.
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post("/addUserInterestsAndTraits", [ProfileController::class, "addUserInterestsAndTraits"])->name("profile.addUserInterestsAndTraits");

    // photos
    Route::post('/uploadPhoto', [PhotoController::class, 'store'])->name('photo.store');
    Route::delete('/deletePhoto', [PhotoController::class, 'destroy'])->name('photo.destroy');

    Route::get("/search", [ProfileController::class, "index"])->name('search');
    Route::get('/viewprofile', [ProfileController::class, 'index'])->name('viewprofile');
    Route::get('/viewprofile/{id}', [ProfileController::class, 'show'])->name('viewprofile');

    // chat
    Route::get("chat", [ChatController::class, "index"])->name("chat.index");
    Route::get("chat/{id}", [ChatController::class, "show"])->name("chat.show");

    // report & ban
    Route::post("report", [AdminController::class, "report"])->name("report.create");

    // error
    Route::get("error", function () {
        return view("error");
    })->name("error");
});

require __DIR__ . '/auth.php';
