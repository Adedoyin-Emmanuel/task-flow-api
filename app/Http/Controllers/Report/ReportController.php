<?php

namespace App\Http\Controllers\Report;

use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;
use App\Repositories\ProjectRepository;




class ReportController extends Controller
{

    protected $taskRepository;
    protected $projectRepository;


    public function __construct(ProjectRepository $projectRepository, TaskRepository $taskRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->taskRepository = $taskRepository;
    }

    public function generateProjectReport(Request $request, string $projectId)
    {
        $project = $this->projectRepository->getProjectById($projectId);
        $tasks =  $this->taskRepository->getTasksByProjectId($projectId);

        $completedTasks = $tasks->where('status', 'completed')->count();
        $pendingTasks = $tasks->where('status', 'pending')->count();
        $overdueTasks = $tasks->where('status', 'overdue')->count();

        $data = [
            'project' => $project,
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks,
            'overdueTasks' => $overdueTasks,
        ];

        $pdf = PDF::loadView('reports.project', $data);
        return $pdf->download("project_{$project->id}_report.pdf");
    }


    public function generateAllProjectsReport(Request $request)
    {

        $projects = $this->projectRepository->getAllProjects();
        $projectSummaries = [];


        foreach($projects as $project) {
            $tasks = $this->taskRepository->getTasksByProjectId($project->id);

            $completedTasks = $tasks->where('status', 'completed')->count();
            $pendingTasks = $tasks->where('status', 'pending')->count();
            $overdueTasks = $tasks->where('status', 'overdue')->count();

            $projectSummaries[] = [
                'project' => $project,
                'completedTasks' => $completedTasks,
                'pendingTasks' => $pendingTasks,
                'overdueTasks' => $overdueTasks,
            ];
        }



        $data = [
            'projects' => $projectSummaries,
        ];

        $pdf = PDF::loadView('reports.all-projects', $data);
        return $pdf->download("all_projects_report.pdf");

    }
}
