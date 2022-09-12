<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

Route::get('/', [EmailController::class, 'index'])->name('index');
Route::post('/store', [EmailController::class, 'store'])->name('emails.store');
Route::delete('/destroy/{email}', [EmailController::class, 'destroy'])->name('emails.destroy');


