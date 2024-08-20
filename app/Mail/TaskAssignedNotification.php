<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskAssignedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $message;

    public function __construct($task, string $message)
    {
        $this->task = $task;
        $this->message = $message;

    }

    public function build()
    {
        return $this->subject($this->message ?? 'You have been assigned a new task')
                    ->view('emails.task-assigned')
                    ->with('task', $this->task);
    }
}

