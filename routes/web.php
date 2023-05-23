<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
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

    Route::get('/companies/{id}/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('/companies/{id}/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::get('/companies/{companyId}/sections/{sectionId}/edit', [SectionController::class, 'edit'])
        ->name('sections.edit');
    Route::put('/companies/{companyId}/sections/{id}', [SectionController::class, 'update'])
        ->name('sections.update');
    Route::delete('/companies/{companyId}/sections/{sectionId}', [SectionController::class, 'destroy'])
        ->name('sections.destroy');
});

require __DIR__ . '/auth.php';
