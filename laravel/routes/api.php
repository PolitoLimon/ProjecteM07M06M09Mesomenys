<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;

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

Route::apiResource('files', FileController::class);
Route::post('files/{file}', [FileController::class, 'update_workaround']);

Route::post('/login', [TokenController::class, 'login']);
Route::post('/register', [TokenController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [TokenController::class, 'user']);
    Route::post('/logout', [TokenController::class, 'logout']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('places', PlaceController::class);
    Route::post('places/{id}/favorite', [PlaceController::class, 'favorite']);
    Route::delete('places/{id}/unfavorite', [PlaceController::class, 'unfavorite']);
    Route::get('/places/{id}/reviews', [ReviewController::class, 'index']);
    Route::post('/places/{id}/reviews', [ReviewController::class, 'store']);
    Route::delete('/places/{id}/reviews/{review}', [ReviewController::class, 'destroy']);
});
 
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::post('posts/{id}', [PostController::class, 'update_workaround']);
    Route::post('/posts/{id}/likes', [PostController::class, 'like']);
    Route::delete('/posts/{id}/likes', [PostController::class, 'unlike']);
    Route::get('posts/{id}/comments', [CommentController::class, 'index']);
    Route::post('posts/{id}/comments', [CommentController::class, 'store']);
    Route::delete('posts/{id}/comments/{commentId}', [CommentController::class, 'destroy']);
});