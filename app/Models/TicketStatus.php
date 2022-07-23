<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color'
    ];

    public function ticket()
    {
        return $this->belongsToMany(Ticket::class);
    }
}
