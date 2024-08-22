<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Task;
use Exception;

class ProjectRepository
{
    /**
     * Create a new project.
     *
     * @param array $data
     * @return \App\Models\Project
     * @throws \Exception
     */
    public function createProject(array $data): Project
    {
        if (strtotime($data['end_date']) <= strtotime($data['start_date'])) {
            throw new Exception('End date must be after start date.');
        }

        $project = Project::create([
            "name" => $data["name"],
            "description" => $data["description"],
            "start_date" => $data["start_date"],
            "end_date" => $data["end_date"],
            "status" => $data["status"] ?? 'pending',
            "project_manager_id" => $data["project_manager_id"]
        ]);

        return $project;
    }


    public function getAllProjects(){
        return Project::all();
    }

    /**
     * Find a project by ID.w
     *
     * @param string $id
     * @return \App\Models\Project|null
     */
    public function getProjectById(string $id): ?Project
    {
        return Project::find($id);
    }


     public function updateProject(string $id, array $data)
    {
        $project = Project::findOrFail($id);

        $project->update($data);

        return $project;
    }


    public function deleteProject(string $id){
        Project::destroy($id);
    }


    public function getAllProjectByUserId(string $userId, string $role)
    {
        if($role == "project manager"){
            return Project::where('project_manager_id', $userId)->get();
        }else{
            $taskIds = Task::where('user_id', $userId)->pluck('id');

            $projectIds = Task::whereIn('id', $taskIds)->pluck('project_id')->unique();

            $projects = Project::whereIn('id', $projectIds)->get();

            return $projects;
        }
    }
}
