<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    function index(Request $request)
    {
        $team = Team::findOrFail($request->team);

        return response()->json([
            'tasks' => $team->tasks,
            'status' => true,
            'message' => 'Tasks found',
        ], 200);
    }

    function store(Request $request)
    {

        $fields = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = Task::create([
            'name' => $fields['name'],
            'description' => $fields['description'],
            'status' => $fields['status'],
            'due_date' => $fields['due_date'],
            'priority' => $fields['priority'],
            'team_id' => $request->team,
            'created_by' => $request->user()->id,
        ]);

        $data = [
            'status' => true,
            'message' => 'Task created',
            'task' => $task,
        ];
        return response()->json($data, 201);
    }

    function show(Request $request)
    {
        $task = Task::where('team_id', $request->team)
            ->where('id', $request->task)
            ->first();

        $data = [
            'status' => true,
            'message' => 'Task found',
            'task' => $task,
        ];
        if (!$task) {
            $data = [
                'status' => false,
                'message' => 'Task not found',
            ];
        }
        return response()->json($data, 200);
    }

    function destroy(Request $request)
    {
        $task = Task::where('team_id', $request->team)
            ->where('id', $request->task)
            ->first();

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Task not found',
            ], 404);
        }

        $task->delete();

        return response()->json([
            'status' => true,
            'message' => 'Task deleted',
        ], 200);
    }
}
