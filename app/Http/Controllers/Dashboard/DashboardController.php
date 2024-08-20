<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;



class DashboardController extends Controller
{
    protected $taskRepository;
    protected $projectRepository;



    public function __construct(ProjectRepository $projectRepository, TaskRepository $taskRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->taskRepository = $taskRepository;
    }


    public function overview(Request $request)
    {

        $projects = $this->projectRepository->getAllProjects();
        $overview = [];


        foreach($projects as $project)
        {
            $tasks = $this->taskRepository->getTasksByProjectId($project->id);
            $totalTasks = $tasks->count();
            $completedTasks = $tasks->where('status', 'completed')->count();
            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            $overview[] = [
                "project" => $project,
                "total_tasks" => $totalTasks,
                "completed_tasks" => $completedTasks,
                "progress" => $progress,
            ];

        }

        return response()->json([
            "success" => true,
            "data" => $overview,
        ]);

    }


    public function overDueTasks(Request $request)
    {

    }



}
