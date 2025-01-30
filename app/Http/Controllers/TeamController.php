<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TeamController extends Controller
{
    function verifyOwnership($team, $user)
    {
        return !$team->members()->where('user_id', $user->id)->where('role', 'owner')->exists();
    }

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
        $team = $request->user()->teams()->find($request->team);
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

    function members(Request $request)
    {
        $team = $request->user()->teams()->find($request->team);
        if (!$team) {
            return response()->json([
                'status' => false,
                'message' => 'Team not found',
            ], 404);
        }
        $data = [
            'status' => true,
            'message' => 'Members found',
            'members' => $team->members,
        ];
        return response()->json($data, 200);
    }

    function storeMember(Request $request)
    {
        $user = $request->user();
        $team = $user->teams()
        ->where('teams.id', $request->team)
        ->withPivot('role')
        ->firstOrFail();
        

        if ($this->verifyOwnership($team, $user)) {
            return response()->json([
                'status' => false,
                'message' => 'Only the owner can add members',
            ], 403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|in:owner,admin,member',
        ]);

        if ($team->members()->where('user_id', $request['user_id'])->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'User is already a member of this team',
            ], 422);
        }

        $team->members()->attach($request['user_id'], ['role' => $request['role'],]);
        
        return response()->json([
            'status' => true,
            'message' => 'Member added',
        ], 200);
    }

    function destroyMember(Request $request)
    {
        $team = $request->user()->teams()->find($request->team);
        if (!$team) {
            return response()->json([
                'status' => false,
                'message' => 'Team not found',
            ], 404);
        }
        $team->members()->detach($request->user);
        $data = [
            'status' => true,
            'message' => 'Member removed',
        ];
        return response()->json($data, 200);
    }
}
