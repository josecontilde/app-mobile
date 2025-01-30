<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskAssignee extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'assigned_at',
    ];
}
