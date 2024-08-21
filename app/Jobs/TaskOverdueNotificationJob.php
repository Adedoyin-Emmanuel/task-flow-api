<?php

namespace App\Jobs;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Mail\TaskOverdueNotification;


class TaskOverdueNotificationJob
{

    protected $taskRepository;
    protected $userRepository;

    public function __construct(TaskRepository $taskRepository, UserRepository $userRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        $overdueTasks = $this->taskRepository->getOverdueTasks();

        if ($overdueTasks->isEmpty()) {
            Log::info("No Overdue tasks were found!");
            return;
        }


        foreach ($overdueTasks as $task) {
            $user = $this->userRepository->getUser($task->assignee);

            Mail::to($user->email)->send(new TaskOverdueNotification($task, $user));
        }
    }
}
