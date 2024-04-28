<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum', 'update_last_active'])->post('/chat', [ChatController::class, 'store']);
Route::middleware(['auth:sanctum'])->post("/geolocation", [ProfileController::class, "updateLocation"]);
Route::middleware(['auth:sanctum'])->post("/interestsTraits", [ProfileController::class, "addUserInterestsAndTraits"]);
