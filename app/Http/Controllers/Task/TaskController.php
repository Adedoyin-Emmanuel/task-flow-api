<?php

namespace App\Http\Controllers\Task;

use Exception;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignedNotification;
use App\Repositories\ProjectRepository;


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



    protected function canStartTask(string $userId, string $projectId)
    {

        $userTasks = $this->taskRepository->getUserProjectTasks($userId, $projectId);

        foreach($userTasks as $userTask)
        {
            if($userTask->status !== 'completed')
            {
                return false;
            }
        }

        return true;
    }

    protected function sendTaskNotification(Task $task, $message)
    {
        $assigneeEmail = $task->assignee->email;
        Mail::to($assigneeEmail)->send(new TaskAssignedNotification($task, $message));
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


    public function changeAssignee(Request $request, string $id)
    {
        try {

            $task = $this->taskRepository->getTaskById($id);
            if (!$task) {
                return response()->json([
                    "success" => false,
                    "message" => "Task with the given ID not found"
                ], 404);
            }

            $validatedData = $request->validate([
                "assignee" => ["required", "string"],
            ]);

            $updatedTask = $this->taskRepository->updateTask($id, $validatedData);

            if($task->assignee !== $validatedData["assignee"]){

                $this->sendTaskNotification($updatedTask, "You've been assigned a task");
            }


            return response()->json([
                    "success" => true,
                    "message" => "Assignee updated successfully",
                    "data" => $updatedTask->assignee
            ], 404);


        } catch (Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()], 500);
        }
    }


    public function changeTaskStatus(Request $request, string $id)
    {
          try {

            $task = $this->taskRepository->getTaskById($id);
            if (!$task) {
                return response()->json([
                    "success" => false,
                    "message" => "Task with the given ID not found"
                ], 404);
            }

            $validatedData = $request->validate([
                "status" => ["required", "string", "in:pending,in progress,completed,overdue"]
            ]);


            $updatedTask = $this->taskRepository->updateTask($id, $validatedData);

            return response()->json([
                "success" => true,
                "message" => "Task status updated successfully",
                "data" => $updatedTask->status
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
            ]);

            $task = $this->taskRepository->getTaskById($id);
            if (!$task) {
                return response()->json([
                    "success" => false,
                    "message" => "Task with the given ID not found"
                ], 404);
            }

            $updatedTask = $this->taskRepository->updateTask($id, $validatedData);

            return response()->json([
                "success" => true,
                "message" => "Task updated successfully",
                "data" => $updatedTask
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
