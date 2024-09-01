<?php
namespace App\Repository\Task\Service;

use App\Repository\Task\Interface\TaskInterface;

class TaskService
{
    protected $task;

    public function __construct(TaskInterface $task)
    {
        $this->task = $task;
    }

    public function index()
    {
        $tasks = $this->task->index();
        return $tasks;
    }

    public function store($data)
    {
        $task = $this->task->store($data);
        return $task;
    }

    public function show($id)
    {
        $task = $this->task->show($id);
        return $task;
    }

    public function update($data, $id)
    {
        $task = $this->task->update($data, $id);
        return $task;
    }

    public function destroy($id)
    {
        $task = $this->task->destroy($id);
        return $task;
    }

    public function search($projectId, $name, $status)
    {
        $task = $this->task->search($projectId, $name, $status);
        return $task;
    }
}
