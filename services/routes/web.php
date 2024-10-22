<?php

use App\Http\Controllers\ShortenedUrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/{shortened_url}', [ShortenedUrlController::class, 'redirect']);

require __DIR__ . '/auth.php';
