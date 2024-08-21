<?php

use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;
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
        Schedule::call(function () {
            $overdueTasks = $this->taskRepository->getOverdueTasks();

            if($overdueTasks->isEmpty()){
                return;
            }

            foreach ($overdueTasks as $task) {

                $user = $this->userRepository->getUser($task->user_id);

                Mail::to($user->email)->send(new TaskOverdueNotification($task));
            }
        })->daily();
    }
}
