<?php

use Illuminate\Support\Facades\Route;

Route::post('/upload-images', Papalardo\Laform\Controllers\ImagesController::class)->name('laform::images.store');
Route::post('/upload-files', Papalardo\Laform\Controllers\FilesController::class)->name('laform::files.store');