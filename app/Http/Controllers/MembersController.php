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
}
