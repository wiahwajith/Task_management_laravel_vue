<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements TaskRepositoryInterface
{
    public function all()
    {
        return Task::where('user_id', Auth::id())->latest()->get();
    }

    public function find($id)
    {
        return Task::where('user_id', Auth::id())->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        return Task::create($data);
    }

    public function update($id, array $data)
    {
        $task = $this->find($id);
        $task->update($data);
        return $task;
    }

    public function delete($id)
    {
        $task = $this->find($id);
        return $task->delete();
    }

    public function markAsCompleted($id)
    {
        $task = $this->find($id);
        $task->status = 'completed';
        $task->save();
        return $task;
    }
}
