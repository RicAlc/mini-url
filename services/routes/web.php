<?php

use App\Http\Controllers\ShortenedUrlController;
use Illuminate\Support\Facades\Route;

Route::get('/r/{shortened_url}', [ShortenedUrlController::class, 'redirect']);

require __DIR__ . '/auth.php';
