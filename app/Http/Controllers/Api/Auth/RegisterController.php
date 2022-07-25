<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @group REGISTER USER
 *
 * Foydalanuvchi ro'yhatdan o'tishi uchun api
 */
class RegisterController extends Controller
{
    /**
     * Ro'yhatdan o'tish
     */
    public function register(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->token = $user->createToken($user->name)->plainTextToken;

        return new UserResource($user);
    }
}
