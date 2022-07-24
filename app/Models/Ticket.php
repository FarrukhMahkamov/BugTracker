<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_compeleted',
        'project_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function ticketUser()
    {
        return $this->belongsToMany(User::class);
    }

    public function ticketStatus()
    {
        return $this->belongsToMany(TicketStatus::class);
    }

    public function ticketTag()
    {
        return $this->belongsToMany(TicketTag::class);
    }
}
