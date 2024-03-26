<?php

use Illuminate\Support\Facades\Route;

Route::prefix('parcel')->group(function () {
    Route::post('/create', [\App\Http\Controllers\ParcelController::class, 'create']);
});
