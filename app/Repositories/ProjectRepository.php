<?php

namespace App\Repositories;

use App\Models\Project;
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
        ]);

        return $project;
    }


    public function getAllProjects(){
        return Project::all();
    }

    /**
     * Find a project by ID.
     *
     * @param string $id
     * @return \App\Models\Project|null
     */
    public function findProjectById(string $id): ?Project
    {
        return Project::find($id);
    }
}
