<?php

namespace App\Http\Controllers\API;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    use ApiResponser;

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        return $this->handleAction(function () use ($request) {
            $tasks = $this->taskService->getAllTasks($request);
            return $this->successResponse($tasks, 'Tasks fetched successfully');
        });
    }

    public function store(Request $request)
    {
        return $this->handleAction(function () use ($request) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);
            $task = $this->taskService->createTask($validated);
            return $this->successResponse($task, 'Task created successfully');
        });
    }

    public function update(Request $request, $id)
    {
        return $this->handleAction(function () use ($request, $id) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'in:pending,completed'
            ]);
            $task = $this->taskService->updateTask($id, $validated);
            return $this->successResponse($task, 'Task updated successfully');
        });
    }

    public function destroy($id)
    {
        return $this->handleAction(function () use ($id) {
            $this->taskService->deleteTask($id);
            return $this->successResponse(null, 'Task deleted successfully');
        });
    }
    public function show($id)
    {
        return $this->handleAction(function () use ($id) {
            $task = $this->taskService->getTaskById($id);
            return $this->successResponse($task, 'Task fetched successfully');
        });
    }

    public function complete($id)
    {
        return $this->handleAction(function () use ($id) {
            $task = $this->taskService->markAsCompleted($id);
            return $this->successResponse($task, 'Task marked as completed');
        });
    }
}
