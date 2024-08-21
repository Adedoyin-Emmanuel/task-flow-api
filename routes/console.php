<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Jobs\TaskDeadlineReminderJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\TaskOverdueNotificationJob;




Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function () {

    Log::info('CRON FIRING ---- TASK OVERDUE');
    $taskRepository = app(TaskRepository::class);
    $userRepository = app(UserRepository::class);

    $taskOverdueNotificationJob = new TaskOverdueNotificationJob($taskRepository, $userRepository);
    $taskOverdueNotificationJob->handle();

})->daily()->at("9:00");



Schedule::call(function (Schedule $schedule) {

    Log::info('CRON FIRING ---- TASK DEADLINE NOTIFICATION');

    $taskRepository = app(TaskRepository::class);
    $userRepository = app(UserRepository::class);

    $taskDeadlineNotificationJob = new TaskDeadlineReminderJob($taskRepository, $userRepository);
    $taskDeadlineNotificationJob->handle();

})->wednesdays()->at("9:00"); // Assuming Fridays are for task submission and review, we can send it 2 days before.
