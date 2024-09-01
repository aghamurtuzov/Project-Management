<?php
namespace App\Repository\Project\Interface;

interface ProjectInterface
{
    public function index();

    public function store($data);

    public function show($id);

    public function update($data, $id);

    public function destroy($id);

    public function search($name);
}
