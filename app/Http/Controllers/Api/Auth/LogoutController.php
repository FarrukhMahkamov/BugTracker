<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'data' => 'Logged out successfully',
        ]);
    }
}
