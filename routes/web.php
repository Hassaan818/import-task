<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/records', [RecordController::class, 'index'])->name('records.index');
    Route::get('/records/import', function () {
        return view('records.import');
    })->name('import.form');

    Route::post('/records/import', [ImportController::class, 'import'])->name('records.import');

    Route::get('/imports', [ImportController::class, 'getImports'])->name('import.index');
});

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

require __DIR__ . '/auth.php';
