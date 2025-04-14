<?php

use App\Http\Controllers\ProfileController;
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
});
Route::get('/manual1', function () {
    return view('manual1');
})->name('manual1');


Route::get('/manual2', function () {
    return view('manual2');
})->name('manual2');

Route::get('/manual3', function () {
    return view('manual3');
})->name('manual3');

Route::get('/manual4', function () {
    return view('manual4');
})->name('manual4');

use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;

Route::get('/professor/selection', [ProfessorController::class, 'showSelectionPage'])->name('professor.selection');
Route::post('/professor/select-correct-image', [ProfessorController::class, 'selectCorrectImage'])->name('professor.selectCorrectImage');

Route::get('/student/selection', [StudentController::class, 'showSelectionPage'])->name('student.selection');
Route::post('/check-answer', [StudentController::class, 'checkAnswer']);

require __DIR__.'/auth.php';
