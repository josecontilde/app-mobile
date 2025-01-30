<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'due_date',
        'priority',
        'team_id',
        'created_by',
    ];

    // Relación: Una tarea pertenece a un equipo
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // Relación: Una tarea fue creada por un usuario
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación: Una tarea puede tener muchos asignados
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_assignees')->withTimestamps();
    }
}
