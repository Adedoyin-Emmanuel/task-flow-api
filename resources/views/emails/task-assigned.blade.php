<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body>
    <h1>You have a new task assigned: {{ $task->title }}</h1>
    <p>Details: {{ $task->description }}</p>

    @php
        $endDate = new \DateTime($task->end_date);
        $formattedDate = $endDate->format('M d, Y');
    @endphp

    <p>Deadline: {{ $formattedDate }}</p>
</body>
</html>
