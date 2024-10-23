<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller {
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request) {
        $request->authenticate();

        $request->session()->regenerate();
        $token = $request->user()->createToken('miniurl')->plainTextToken;
        $userName = $request->user()->name;
        return response([
            'message' => 'Login successful',
            'name' => $userName
        ])->cookie('session_token', $token, 60, '/', null, false, false, false);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
