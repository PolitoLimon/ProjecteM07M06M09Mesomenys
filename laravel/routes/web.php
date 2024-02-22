<?php

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommentController;

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

Route::get('/', function (Request $request) {
    $message = 'Loading welcome page';
    Log::info($message);
    $request->session()->flash('info', $message);
    // return view('welcome');
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('mail/test', [MailController::class, 'test']);

Route::resource('files', FileController::class)
    ->middleware(['auth']);

Route::resource('places', PlaceController::class)
    ->middleware(['auth']);

Route::resource('posts', PostController::class)
    ->middleware(['auth']);


Route::get('places.search', 'App\Http\Controllers\PlaceController@search')->name('places.search');
Route::get('posts.search', 'App\Http\Controllers\PostController@search')->name('posts.search');


Route::post('/places/{place}/favorites', 'App\Http\Controllers\PlaceController@favorite')
    ->name('places.favorites')
    ->middleware('can:create,place');

Route::get('/places/{place}/reviews', 'App\Http\Controllers\ReviewController@index')
    ->name('places.reviews.index');
Route::post('/places/{place}/reviews', 'App\Http\Controllers\ReviewController@store')
    ->name('places.reviews.store');
Route::delete('/places/{place}/reviews/{reviewId}', 'App\Http\Controllers\ReviewController@destroy')
    ->name('places.reviews.destroy');

Route::delete('/places/{place}/favorites', 'App\Http\Controllers\PlaceController@unfavorite')->name('places.unfavorites');


Route::get('/language/{locale}', [LanguageController::class, 'language'])->name('language');


Route::post('/posts/{post}/likes', 'App\Http\Controllers\PostController@like')->name('posts.likes');
Route::delete('/posts/{post}/likes', 'App\Http\Controllers\PostController@unlike')->name('posts.unlike');

Route::get('/about-us', function () {
    return view('about.index');
})->middleware(['auth', 'verified'])->name('about');

Route::get('/about-cristian', function () {
    return view('about.cristian.index');
})->middleware(['auth', 'verified'])->name('about-cristian');

Route::get('/about-gerard', function () {
    return view('about.gerard.index');
})->middleware(['auth', 'verified'])->name('about-gerard');

Route::get('posts/{id}/comments', [CommentController::class, 'index']);
Route::delete('posts/{id}/comments', [CommentController::class, 'destroy'])->name('comment.delete');
Route::post('posts/{id}/comments', [CommentController::class, 'store'])->name('comment.store');

require __DIR__.'/auth.php';