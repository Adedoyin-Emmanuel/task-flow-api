<!DOCTYPE html>
<html>
<head>
    <title>Task Deadline Reminder</title>
</head>
<body>
    <h1>Reminder: Task Deadline Approaching</h1>
    <p>Dear {{ $task->assignedUser->name }},</p>
    <p>The deadline for the task "{{ $task->title }}" is approaching.</p>
    <p>Details:</p>
    <ul>
        <li><strong>Task:</strong> {{ $task->title }}</li>
        <li><strong>Description:</strong> {{ $task->description }}</li>
        <li><strong>Deadline:</strong> {{ date('M d, Y', strtotime($task->end_date)) }}</li>
    </ul>
    <p>Please ensure the task is completed on time.</p>
    <p>Thank you!</p>
</body>
</html>
