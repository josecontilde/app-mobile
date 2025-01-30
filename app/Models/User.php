<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     // Relación: Un usuario puede pertenecer a muchos equipos
     public function teams()
     {
         return $this->belongsToMany(Team::class, 'team_members')->withPivot('role')->withTimestamps();
     }
 
     // Relación: Un usuario puede haber creado muchas tareas
     public function tasksCreated()
     {
         return $this->hasMany(Task::class, 'created_by');
     }
 
     // Relación: Un usuario puede estar asignado a muchas tareas
     public function assignedTasks()
     {
         return $this->belongsToMany(Task::class, 'task_assignees')->withTimestamps();
     }

}
