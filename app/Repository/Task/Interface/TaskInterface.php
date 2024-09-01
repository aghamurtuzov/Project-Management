<?php
namespace App\Repository\Task\Interface;

interface TaskInterface
{
    public function index();

    public function store($data);

    public function show($id);

    public function update($data, $id);

    public function destroy($id);

    public function search($projectId, $name, $status);
}
