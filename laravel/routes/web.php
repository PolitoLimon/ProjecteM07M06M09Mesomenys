<?php

use App\Http\Controllers\ProfileController;
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
 
Route::get('/', function () {
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

#------Ruta Request

use Illuminate\Http\Request;
// ...
Route::get('/dashboard', function (Request $request) {
    $request->session()->flash('info', 'TEST flash messages');
    return view('dashboard');
 })->middleware(['auth','verified'])->name('dashboard');;




#-------------Ruta MailController
use App\Http\Controllers\MailController;
// ...
Route::get('mail/test', [MailController::class, 'test']);

// or
// Route::get('mail/test', 'App\Http\Controllers\MailController@test');




require __DIR__.'/auth.php';
