<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Repository\Project\Service\ProjectService;
use App\Services\ApiResponse;
use Illuminate\Http\Request;
use Exception;

class ProjectController extends Controller
{
    use ApiResponse;

    protected $project;

    public function __construct(ProjectService $project)
    {
        $this->project = $project;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = $this->project->index();
        return $this->sendResponse($projects, 'Project data successfully retrieved.', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        try {
            $request->validated();
            $project = $this->project->store($request->all());
            return $this->sendResponse($project, 'Project data successfully created.', 201);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 'Failed to create project.', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = $this->project->show($id);
        return $this->sendResponse($project, 'Project data successfully retrieved.', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, string $id)
    {
        try {
            $request->validated();
            $this->project->update($request->all(), $id);
            return $this->sendResponse([], 'Project data successfully updated.', 200);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 'Failed to update project.', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->project->destroy($id);
            return $this->sendResponse([], 'Project data successfully deleted.', 204);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 'Failed to delete project.', 400);
        }
    }

    /**
     * Search for resources.
     */
    public function search(Request $request)
    {
        $name = $request->get('name');
        $projects = $this->project->search($name);
        return $this->sendResponse($projects, 'Project search results successfully retrieved.', 200);
    }
}
