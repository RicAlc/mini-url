<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortenedUrlController;

Route::post('/shorten', [ShortenedUrlController::class, 'addOne']);
Route::get('/myurls', [ShortenedUrlController::class, 'getAllByUser']);
Route::get('/geturl/{id}', [ShortenedUrlController::class, 'getOne']);
Route::post('/edit', [ShortenedUrlController::class, 'update']);
Route::delete('/deleteUrl', [ShortenedUrlController::class, 'delete']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
