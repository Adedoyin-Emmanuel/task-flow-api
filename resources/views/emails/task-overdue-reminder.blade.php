<!DOCTYPE html>
<html>
<head>
    <title>Task Overdue Notification</title>
</head>
<body>
    <h1>Task Overdue Notification</h1>
    <p>Dear {{ $task->assignedUser->name }},</p>
    <p>The task "{{ $task->title }}" is overdue.</p>
    <p>Details:</p>
    <ul>
        <li><strong>Task:</strong> {{ $task->title }}</li>
        <li><strong>Description:</strong> {{ $task->description }}</li>
        <li><strong>Deadline:</strong> {{ date('M d, Y', strtotime($task->end_date)) }}</li>
    </ul>
    <p>Please address this issue as soon as possible.</p>
    <p>Thank you!</p>
</body>
</html>
