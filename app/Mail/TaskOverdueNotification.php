<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskOverdueNotification extends Mailable
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
    public function __construct($task, string $message = 'Task Overdue Notification')
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
                    ->view('emails.task-overdue')
                    ->with([
                        'task' => $this->task,
                    ]);
    }
}
