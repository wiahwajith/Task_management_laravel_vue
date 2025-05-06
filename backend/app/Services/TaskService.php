<?php

namespace App\Services;

use App\Interfaces\TaskRepositoryInterface;

class TaskService
{
    protected $taskRepo;

    public function __construct(TaskRepositoryInterface $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    public function getAllTasks($filters)
    {
        return $this->taskRepo->all($filters);
    }

    public function createTask(array $data)
    {
        return $this->taskRepo->create($data);
    }

    public function updateTask($id, array $data)
    {
        return $this->taskRepo->update($id, $data);
    }

    public function deleteTask($id)
    {
        return $this->taskRepo->delete($id);
    }

    public function markAsCompleted($id)
    {
        return $this->taskRepo->markAsCompleted($id);
    }
}
