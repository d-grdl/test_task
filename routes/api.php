<?php

use App\Http\Controllers\TagController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\PictureController;
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

Route::prefix('video')->group(function() {
    Route::get('/', [VideoController::class, 'index']);
    Route::post('/create', [VideoController::class, 'store']);
    Route::get('/recent', [VideoController::class, 'recentlyUploaded']);
    Route::get('/{videoId}', [VideoController::class, 'getById']);
    Route::put('/{videoId}/edit', [VideoController::class, 'update']);
    Route::delete('/{videoId}/delete', [VideoController::class, 'delete']);

});

Route::prefix('tags')->group(function() {
    Route::get('/', [TagController::class, 'index']);
    Route::post('/create', [TagController::class, 'store']);
    Route::get('/{tagId}', [TagController::class, 'getById']);
    Route::put('/{tagId}/edit', [TagController::class, 'update']);
    Route::delete('/{tagId}/delete', [TagController::class, 'delete']);
    Route::get('/{tagId}/videos', [TagController::class, 'filter']);
});

Route::prefix('picture')->group(function() {
    Route::post('/upload', [PictureController::class, 'upload']);
    Route::delete('/{pictureId}/delete', [PictureController::class, 'delete']);
});

