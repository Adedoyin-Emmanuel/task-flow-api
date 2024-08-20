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
                "status" => ["nullable", "string", "in:pending,in progress,completed,overdue"]
            ]);

            $project = $this->projectRepository->createProject($validatedData);

            return response()->json([
                "success" => true,
                "message" => "Project created successfully",
                "data" => $project
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
