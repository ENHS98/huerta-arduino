<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::post('/postvalores', [DashboardController::class, 'postValores'])->name('valores.store');