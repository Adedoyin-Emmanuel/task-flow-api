<?php

use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;
use App\Mail\TaskDeadlineReminder;


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
        Schedule::call(function () {
            $tasksNearingDeadline = $this->taskRepository->getNearingDeadlineTasks();

            if ($tasksNearingDeadline->isEmpty()) {
                return;
            }

            foreach ($tasksNearingDeadline as $task) {

                $user = $this->userRepository->getUser($task->user_id);

                Mail::to($user->email)->send(new TaskDeadlineReminder($task));
            }
        })->wednesdays(); // Let's say Friday is usually standup meettinng
    }
}
