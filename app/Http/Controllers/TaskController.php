<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    function index(Request $request)
    {
        $user = $request->user();
        $tasks = Task::where('created_by', $user->id)->get();
        $data = [
            'status' => true,
            'message' => 'Tasks found',
            'tasks' => $tasks,
        ];
        if (!$tasks) {
            $data = [
                'status' => false,
                'message' => 'Tasks not found',
            ];
        }
        return response()->json($data, 200);   
    }

    function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'status' => 'required|in:pending,in_progress,completed',
                'due_date' => 'required|date',
                'priority' => 'required|in:low,medium,high',
                'team_id' => 'required|integer',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }

        $task = Task::create([
            'name' => $fields['name'],
            'description' => $fields['description'],
            'status' => $fields['status'],
            'due_date' => $fields['due_date'],
            'priority' => $fields['priority'],
            'team_id' => $fields['team_id'],
            'created_by' => $request->user()->id,
        ]);

        $data = [
            'status' => true,
            'message' => 'Task created',
            'task' => $task,
        ];
        return response()->json($data, 201);
    }
}
