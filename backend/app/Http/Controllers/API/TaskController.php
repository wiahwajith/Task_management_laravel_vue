<?php

namespace App\Http\Controllers\API;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;

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

    public function store(TaskStoreRequest $request)
    {
        return $this->handleAction(function () use ($request) {

            $task = $this->taskService->createTask($request->all());
            return $this->successResponse($task, 'Task created successfully');
        });
    }

    public function update(TaskUpdateRequest $request, $id)
    {
        return $this->handleAction(function () use ($request, $id) {

            $task = $this->taskService->updateTask($id, $request->all());
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
