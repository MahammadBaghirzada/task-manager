<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Project $project): bool
    {
        return $user->id === $project->creator_id || $user->memberships->contains($project);
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Project $project): bool
    {
        //
    }

    public function delete(User $user, Project $project): bool
    {
        //
    }

    public function restore(User $user, Project $project): bool
    {
        //
    }

    public function forceDelete(User $user, Project $project): bool
    {
        //
    }
}
