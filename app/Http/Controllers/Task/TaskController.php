<?php

namespace App\Http\Controllers\Task;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;


class TaskController extends Controller
{

    protected $taskRepository;
    protected $userRepository;
    protected   $projectRepository;

    public function __construct(TaskRepository $taskRepository, UserRepository $userRepository, ProjectRepository
    $projectRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
    }


    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "name" => ["required", "string", "max:255"],
                "description" => ["required", "string"],
                "start_date" => ["required", "date"],
                "assignee" => ["required", "string"],
                "project_id" => ["required", "string"],
                "end_date" => ["required", "date"],
                "status" => ["nullable", "string", "in:pending,in progress,completed,overdue"]
            ]);


            $task = $this->taskRepository->createTask($validatedData);
            $user = $this->userRepository->getUser($task->assignee);

            // if($user->role !== "team member"){
            //     return response()->json(["success" => false, "message" => "Only team members can be assigned tasks"], 403);
            // }

            $project = $this->projectRepository->getProjectById($task->project_id);


            $emailContent = "Hi, $user->name You've been assigned  on $task->name, in project $project->name. Please login to view your task.";

            Mail::raw($emailContent, function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Action Required: Task Assigned');
            });


            return response()->json([
                "success" => true,
                "message" => "Task created and assigned successfully",
                "data" => $task
            ]);



        } catch (Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
        }
    }


    public function getAll(Request $request){
        try {
            $allTasks = $this->taskRepository->getAllTasks();

             return response()->json([
                "success" => true,
                "message" => "All tasks retrived successfully",
                "total_tasks" => count($allTasks),
                "data" => $allTasks
            ]);


        }  catch (Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
        }
    }


    public function getById(Request $request, string $id){

        try {
            $task = $this->taskRepository->getTaskById($id);

            if(!$task){
                return response()->json([
                    "success" => false,
                    "message" => "Task with given id not found",
                    "data" => null
                ], 404);
            }

            return response()->json([
                "success" => true,
                "message" => "Task retrived successfully",
                "data" => $task
            ]);
        }catch (Exception $exception) {
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
                "assignee" => ["sometimes", "string"],
                "end_date" => ["sometimes", "date"],
                "status" => ["sometimes", "string", "in:pending,in progress,completed,overdue"]
            ]);

            $task = $this->taskRepository->updateTask($id, $validatedData);


            if(!$task){
                return response()->json([
                    "success" => false,
                    "message" => "Task with given id not found"
                ], 404);
            }

            return response()->json([
                "success" => true,
                "message" => "Task updated successfully",
                "data" => $task
            ]);


        } catch (Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
        }
    }


    public function delete(Request $request, string $id)

    {
        try {

            $task = $this->taskRepository->deleteTask($id);

            if(!$task){
                return response()->json([
                    "success" => false,
                    "message" => "Task with given id not found"
                ], 404);
            }

            return response()->json([
                "success" => true,
                "message" => "Task deleted successfully"
            ]);

        } catch (Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
        }
    }
    


}
