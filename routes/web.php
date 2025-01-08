<?php

use App\Http\Controllers\WebProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [WebProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [WebProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [WebProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
