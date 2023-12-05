<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LanguageController;


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
    return view('welcome');
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
    ->middleware(['auth' ]);

Route::get('places.search', 'App\Http\Controllers\PlaceController@search')->name('places.search');

Route::post('/places/{place}/favs', 'PlaceController@favorite')->name('places.favorite');
Route::delete('/places/{place}/favs', 'PlaceController@unfavorite')->name('places.unfavorite');

Route::resource('posts', PostController::class)
    ->middleware(['auth']);

Route::post('/posts/{post}/likes', 'PostController@like')->name('posts.like');
Route::delete('/posts/{post}/likes', 'PostController@unlike')->name('posts.unlike');

Route::get('posts.search', 'App\Http\Controllers\PostController@search')->name('posts.search');



#######-------Ruta /home----------------#######3

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::post('/posts/{post}/like', 'PostController@like')->middleware('auth');
Route::delete('/posts/{post}/unlike', 'PostController@unlike')->middleware('auth');


Route::post('/places/{place}/favorite', 'PlaceController@favorite')->middleware('auth');
Route::delete('/places/{place}/unfavorite', 'PlaceController@unfavorite')->middleware('auth');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});
Route::get('/language/{locale}', [LanguageController::class, 'language'])->name('language');

require __DIR__.'/auth.php';