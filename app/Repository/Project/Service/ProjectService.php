<?php
namespace App\Repository\Project\Service;

use App\Repository\Project\Interface\ProjectInterface;

class ProjectService {
    protected $project;

    public function __construct(ProjectInterface $project) {
        $this->project = $project;
    }

    public function index() {
        $projects = $this->project->index();
        return $projects;
    }

    public function store($data) {
        $project = $this->project->store($data);
        return $project;
    }

    public function show($id) {
        $project = $this->project->show($id);
        return $project;
    }

    public function update($data, $id) {
        $project = $this->project->update($data, $id);
        return $project;
    }

    public function destroy($id) {
        $project = $this->project->destroy($id);
        return $project;
    }

    public function search($name) {
        $project = $this->project->search($name);
        return $project;
    }
}
