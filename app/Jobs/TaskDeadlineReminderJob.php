<?php

namespace App\Jobs;
use App\Mail\TaskDeadlineReminder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;


class TaskDeadlineReminderJob
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
        $tasksNearingDeadline = $this->taskRepository->getNearingDeadlineTasks();

        if ($tasksNearingDeadline->isEmpty()) {
            Log::info("No Task nearing deadline found!");
            return;
        }

        foreach ($tasksNearingDeadline as $task) {

            $user = $this->userRepository->getUser($task->assignee);

            Mail::to($user->email)->send(new TaskDeadlineReminder($task, $user));
        }
    }
}
