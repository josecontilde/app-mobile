<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    function verifyOwnership($team, $user)
    {
        return !$team->members()->where('user_id', $user->id)->where('role', 'owner')->exists();
    }
    
    function index(Request $request)
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

    function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|in:owner,admin,member',
        ]);
        
        $team = $request->user()->teams()->find($request->team);

        $team->members()->attach($request['user_id'], ['role' => $request['role'],]);
        
        return response()->json([
            'status' => true,
            'message' => 'Member added',
        ], 200);
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
        $team->members()->detach($request->user);
        $data = [
            'status' => true,
            'message' => 'Member removed',
        ];
        return response()->json($data, 200);
    }

}
