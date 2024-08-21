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

    public $user;

    /**
     * Create a new message instance.
     *
     * @param $task
     * @param string $message
     */
    public function __construct($task, $user, string $message = 'Urgent: Task Overdue Notification')
    {
        $this->task = $task;
        $this->message = $message;
        $this->user = $user;
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
                        'user' => $this->user
                    ]);
    }
}
