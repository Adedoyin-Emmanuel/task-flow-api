<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body>
    <h1>You have a new task assigned: {{ $task->title }}</h1>
    <p>Details: {{ $task->description }}</p>
    <p>Deadline: {{ $task->end_date->format('M d, Y') }}</p>
</body>
</html>
