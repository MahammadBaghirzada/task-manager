<?php

namespace App\Observers;

use App\Models\Project;

class ProjectObserver
{
    public function created(Project $project): void
    {
        $project->members()->attach([$project->creator_id]);
    }

    public function updated(Project $project): void
    {
        //
    }

    public function deleted(Project $project): void
    {
        //
    }

    public function restored(Project $project): void
    {
        //
    }

    public function forceDeleted(Project $project): void
    {
        //
    }
}
