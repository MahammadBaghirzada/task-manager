<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\Project;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function index(Project $project): UserCollection
    {
        $members = $project->members;

        return new UserCollection($members);
    }

    public function store(Request $request, Project $project): UserCollection
    {
        $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $project->members()->syncWithoutDetaching([$request->user_id]);

        $members = $project->members;

        return new UserCollection($members);
    }
}
