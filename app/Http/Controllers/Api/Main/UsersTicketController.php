<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\Ticket\UsersTicketResource;
use App\Models\User;

class UsersTicketController extends Controller
{
    public function getUsersTicket($user_id, $project_id)
    {
        $user = User::findOrFail($user_id);

        return UsersTicketResource::collection($user->ticket->where('project_id', $project_id));
    }
}
