<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    public function project()
    {
        return $this->belongsToMany(Project::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
