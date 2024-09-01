<?php
namespace App\Repository\Task;

use App\Models\Task;
use App\Repository\Task\Interface\TaskInterface;

class TaskRepository implements TaskInterface
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function index()
    {
        $tasks = $this->task->orderByDesc('id')->get();
        return $tasks;
    }

    public function store($data)
    {
        $task = $this->task::create($data);
        return $task;
    }

    public function show($id)
    {
        $task = $this->task::findOrFail($id);
        return $task;
    }

    public function update($data, $id)
    {
        $task = $this->task::findOrFail($id);
        $task->fill($data);
        $task->save();
        return $task;
    }

    public function destroy($id)
    {
        $task = $this->task::findOrFail($id);
        $task->delete();
        return $task;
    }

    public function search($projectId, $name, $status)
    {
        $tasks = $this->task->projectId($projectId)->name($name)->status($status)->get();
        return $tasks;
    }
}
