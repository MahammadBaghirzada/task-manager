<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function index(): TaskCollection
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                'is_done',
                'scheduled_at',
                'due_at',
                AllowedFilter::scope('scheduled_between'),
                AllowedFilter::scope('due_between'),
                AllowedFilter::scope('due', null, 'past,today'),
            ])
            ->defaultSort('-created_at')
            ->allowedSorts(['title', 'is_done', 'created_at'])
            ->paginate(10);

        return new TaskCollection($tasks);
    }

    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        $validated = $request->validated();

        $task = Auth::user()->tasks()->create($validated);

        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $validated = $request->validated();

        $task->update($validated);

        return new TaskResource($task);
    }

    public function destroy(Task $task): Response
    {
        $task->delete();

        return response()->noContent();
    }
}
