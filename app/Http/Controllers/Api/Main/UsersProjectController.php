<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\Project\UsersProjectResource;
use App\Models\User;

/**
 * @group FOYDALANUVCHI VA LOYIHA
 *
 * Foydalanuvchi va uning loyihalar bilan amallari uchun API
 */
class UsersProjectController extends Controller
{
    /**
     * Foydalanuvchi qo'shilgan loyihalar ro'yhati
     */
    public function getUsersProject($id)
    {
        $user = User::findOrFail($id);

        return UsersProjectResource::collection($user->projects);
    }
}
