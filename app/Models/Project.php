<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'project_owner'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function projectOwner()
    {
        return $this->belongsTo(User::class, 'project_owner');
    }

    public function ticket()
    {
        return $this->belongsToMany(Ticket::class);
    }
}
