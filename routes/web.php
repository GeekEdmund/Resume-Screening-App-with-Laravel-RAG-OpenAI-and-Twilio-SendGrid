<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeController;

Route::get('/', [ResumeController::class, 'showUploadForm'])->name('upload.form');
Route::post('/upload', [ResumeController::class, 'uploadResume'])->name('upload.resume');
Route::get('/extract-text/{file}', [PdfController::class, 'extractTextFromPdf']);

Route::get('/', function () {
    return view('upload');
});

