<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionUserController;
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
    Route::resource('companies', \App\Http\Controllers\CompanyController::class);

    Route::get('/companies/{company}/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('/companies/{company}/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::get('/companies/{company}/sections/{section}/edit', [SectionController::class, 'edit'])
        ->name('sections.edit');
    Route::put('/companies/{company}/sections/{section}', [SectionController::class, 'update'])
        ->name('sections.update');
    Route::get('/companies/{company}/sections/{section}', [SectionController::class, 'show'])
        ->name('sections.show');
    Route::delete('/companies/{company}/sections/{section}', [SectionController::class, 'destroy'])
        ->name('sections.destroy');
    Route::post('/companies/{company}/sections/{section}', [SectionUserController::class, 'store'])
        ->name('section_user.store');
});

require __DIR__ .'/auth.php';
