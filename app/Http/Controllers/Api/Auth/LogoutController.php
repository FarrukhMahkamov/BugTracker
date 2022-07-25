<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
