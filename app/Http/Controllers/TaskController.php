<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function index(): TaskCollection
    {
        $tasks = QueryBuilder::for(Task::class)->allowedFilters('is_done')->paginate();

        return new TaskCollection($tasks);
    }

    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        $validated = $request->validated();

        $task = Task::query()->create($validated);

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
