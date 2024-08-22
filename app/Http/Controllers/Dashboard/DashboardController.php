<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Auth;



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
        try {

            $projects = $this->projectRepository->getAllProjects();
            $overview = [];

            Log::info($request->attributes->get("role"));
            Log::info($request->attributes->get("user_id"));


            $role = $request->attributes->get("role");

            if($role === "admin"){
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
                        "progress" => round($progress),
                    ];

                }

            return response()->json([
                "success" => true,
                "data" => $overview,
            ]);

            }else if($role == "project manager"){
                $projects = $this->projectRepository->getAllProjectByUserId($request->attributes->get("user_id"), "project manager");

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

            }else{

                $userId = $request->attributes->get("user_id", null);
                $role = $request->attributes->get("role", null);

               $projects = $this->projectRepository->getAllProjectByUserId($userId, $role);

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

            }




        } catch (Exception $exception) {
             return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
        }

    }


    public function overdueTasks(Request $request)
    {
       try {

            $status = $request->query("status", null);
            $overdueTasks = $this->taskRepository->getOverdueTasks($status);

            return response()->json([
                "success" => true,
                "mesage" => "",
                "data" => $overdueTasks,
            ]);

       } catch (Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
       }
    }



}
