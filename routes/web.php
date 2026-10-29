<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CompatibilityController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\TestSessionController;
use App\Http\Controllers\TypeProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/tes/mulai', [TestSessionController::class, 'create'])->name('test.create');
Route::post('/tes', [TestSessionController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('test.store');
Route::get('/tes/{userTest}', [TestSessionController::class, 'show'])->name('test.show');
Route::patch('/tes/{userTest}/jawaban', [AnswerController::class, 'update'])
    ->middleware(['throttle:120,1', 'test.active'])
    ->name('test.answers');
Route::post('/tes/{userTest}/selesai', [TestSessionController::class, 'submit'])
    ->middleware('test.active')
    ->name('test.submit');

Route::get('/hasil/{userTest}', [ResultController::class, 'show'])->name('result.show');
Route::get('/hasil/{userTest}/sertifikat', [ResultController::class, 'certificate'])->name('result.certificate');

Route::get('/tipe', [TypeProfileController::class, 'index'])->name('types.index');
Route::get('/tipe/{mbtiType}', [TypeProfileController::class, 'show'])->name('types.show');

Route::get('/kecocokan', [CompatibilityController::class, 'index'])->name('compatibility.index');
Route::get('/kecocokan/{left}/{right}', [CompatibilityController::class, 'show'])
    ->name('compatibility.show');
