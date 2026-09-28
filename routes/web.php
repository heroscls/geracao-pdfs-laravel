<?php

use App\Http\Controllers\FichaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FichaController::class, 'index'])->name('fichas.index');
Route::get('/fichas/{ficha}/pdf', [FichaController::class, 'visualizar'])->name('fichas.pdf');
Route::get('/fichas/{ficha}/pdf/baixar', [FichaController::class, 'baixar'])->name('fichas.baixar');