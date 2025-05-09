<?php

namespace App\Services;

use App\Constants\Constants;
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
        $status = $filters->get('status', 'all'); 
        $page = $filters->get('page', 1);         
        $userId = auth()->id();
        $perPage = Constants::PER_PAGE;

        return $this->taskRepo->all([
            'status' => $status,
            'page' => $page,
            'user_id' => $userId,
            'per_page' => $perPage
        ]);
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
    public function getTaskById($id)
    {
        return $this->taskRepo->getTaskById($id);
    }

    public function markAsCompleted($id)
    {
        return $this->taskRepo->markAsCompleted($id);
    }
}
