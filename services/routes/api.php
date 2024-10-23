<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortenedUrlController;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/shorten', [ShortenedUrlController::class, 'addOne']);
    Route::get('/myurls', [ShortenedUrlController::class, 'getAllByUser']);
    Route::get('/geturl/{id}', [ShortenedUrlController::class, 'getOne']);
    Route::post('/edit', [ShortenedUrlController::class, 'update']);
    Route::delete('/deleteUrl', [ShortenedUrlController::class, 'delete']);
});

Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
