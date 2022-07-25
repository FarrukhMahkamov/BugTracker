<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\Auth\UserResource;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $reques)
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            [
                'google_id' => $googleUser->id
            ],[
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id
        ]);

        $user->token = $user->createToken($user->email)->plainTextToken;

        return new UserResource($user);  
    }
}
