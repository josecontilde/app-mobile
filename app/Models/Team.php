<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relación: Un equipo tiene muchos miembros (usuarios)
    public function members()
    {
        return $this->belongsToMany(User::class, 'team_members')->withPivot('role')->withTimestamps();
    }

    // Relación: Un equipo tiene muchas tareas
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
