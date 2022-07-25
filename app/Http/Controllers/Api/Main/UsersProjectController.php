<?php

namespace App\Http\Controllers\Api\Main;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Project\UsersProjectResource;

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
