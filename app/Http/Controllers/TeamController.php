<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TeamController extends Controller
{
    function index(Request $request)
    {
        $data = [
            'teams' => $request->user()->teams,
        ];
        return response()->json($data, 200);
    }

    function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }

        $team = Team::create([
            'name' => $fields['name'],
        ]);

        $team->members()->attach($request->user()->id, [
            'role' => 'owner',
        ]);

        $data = [
            'status' => true,
            'message' => 'Team created',
            'team' => $team,
        ];
        return response()->json($data, 201);
    }

    function show(Request $request)
    {
        $team = $request->user()->teams()->where('teams.id', $request->team)
                                  ->orWhere('teams.name', $request->team)
                                  ->first();
        $data = [
            'status' => true,
            'message' => 'Team found',
            'team' => $team,
        ];
        if (!$team) {
            $data = [
                'status' => false,
                'message' => 'Team not found',
            ];
        }
        return response()->json($data, 200);
    }

    function update(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }
        $team = $request->user()->teams()->find($request->team);
        if (!$team) {
            return response()->json([
                'status' => false,
                'message' => 'Team not found',
            ], 404);
        }
        $team->update($fields);
        $data = [
            'status' => true,
            'message' => 'Team updated',
            'team' => $team,
        ];
        return response()->json($data, 200);
    }

    function destroy(Request $request)
    {
        $team = $request->user()->teams()->find($request->team);
        if (!$team) {
            return response()->json([
                'status' => false,
                'message' => 'Team not found',
            ], 404);
        }
        $team->delete();
        $data = [
            'status' => true,
            'message' => 'Team deleted',
        ];
        return response()->json($data, 200);
    }

    
}
