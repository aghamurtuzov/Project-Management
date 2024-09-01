<?php
namespace App\Repository\Project;

use App\Models\Project;
use App\Repository\Project\Interface\ProjectInterface;

class ProjectRepository implements ProjectInterface {
    protected $project;

    public function __construct(Project $project) {
        $this->project = $project;
    }

    public function index() {
        $projects = $this->project->orderByDesc('id')->paginate(10);
        return $projects;
    }

    public function store($data) {
        $project = $this->project::create($data);
        return $project;
    }

    public function show($id) {
        $project = $this->project->with('task')->findOrFail($id);
        return $project;
    }

    public function update($data, $id) {
        $project = $this->project->findOrFail($id);
        $project->fill($data);
        $project->save();
        return $project;
    }

    public function destroy($id) {
        $project = $this->project::findOrFail($id);
        $project->delete();
        return $project;
    }

    public function search($name) {
        $projects = $this->project->name($name)->orderByDesc('id')->paginate(10);
        return $projects;
    }
}
