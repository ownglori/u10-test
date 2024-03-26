<?php

use Illuminate\Support\Facades\Route;

Route::prefix('parcel')->group(function () {
    Route::get('/create', [\App\Http\Controllers\ParcelController::class, 'create']);
});
