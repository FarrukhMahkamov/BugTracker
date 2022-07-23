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
        return $this->belongsToMany(User::class)
        ->withPivot(['is_manager'])
        ->withTimestamps()
        ->as('project_user');
    }

    public function projectOwner()
    {
        return $this->belongsTo(User::class, 'project_owner');
    }

    public function ticket()
    {
    return $this->hasMany(Ticket::class);
    }
}
