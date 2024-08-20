<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskDeadlineReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $message;

    /**
     * Create a new message instance.
     *
     * @param $task
     * @param string $message
     */
    public function __construct($task, string $message = 'Task Deadline Reminder')
    {
        $this->task = $task;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->message)
                    ->view('emails.task-deadline-reminder')
                    ->with([
                        'task' => $this->task,
                    ]);
    }
}
