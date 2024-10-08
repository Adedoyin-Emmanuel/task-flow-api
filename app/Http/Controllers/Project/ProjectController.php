<?php

namespace App\Http\Controllers\Project;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepository;

class ProjectController extends Controller
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "name" => ["required", "string", "max:255"],
                "description" => ["required", "string"],
                "start_date" => ["required", "date"],
                "end_date" => ["required", "date"],
                "status" => ["nullable", "string", "in:pending,in progress,completed,overdue"],
                "project_manager_id" => ["required", "string", "exists:users,id"]
            ]);

            $project = $this->projectRepository->createProject($validatedData);

            return response()->json([
                "success" => true,
                "message" => "Project created successfully",
                "data" => $project
            ]);
        } catch (Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
        }
    }


    public function getAll(Request $request){

        try {

            $allProjects = $this->projectRepository->getAllProjects();

            return response()->json([
                "success" => true,
                "message" => "All projects retrived successfully",
                "total_projects" => count($allProjects),
                "data" => $allProjects
            ]);

        } catch (Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
        }
    }


    public function getById(Request $request, string $id){
       try {

            $project = $this->projectRepository->getProjectById($id);


            if(!$project){
                return response()->json([
                    "success" => false,
                    "message" => "Project with given id not found",
                    "data" => null
                ], 404);
            }

            return response()->json([
                "success" => true,
                "message" => "Project retrived successfully",
                "data" => $project
            ]);

        } catch (Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
        }
    }


    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                "name" => ["sometimes", "string", "max:255"],
                "description" => ["sometimes", "string"],
                "start_date" => ["sometimes", "date"],
                "end_date" => ["sometimes", "date"],
                "status" => ["nullable", "string", "in:pending,in progress,completed,overdue"]
            ]);

            $project = $this->projectRepository->updateProject($id, $validatedData);

            return response()->json([
                "success" => true,
                "message" => "Project updated successfully",
                "data" => $project
            ]);
        } catch (Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
        }

    }


    public function delete(Request $request, string $id)
    {
          try {

            $this->projectRepository->deleteProject($id);

            return response()->json([
                "success" => true,
                "message" => "Project deleted successfully",
                "data" => null
            ]);
        } catch (Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
        }

    }



}
