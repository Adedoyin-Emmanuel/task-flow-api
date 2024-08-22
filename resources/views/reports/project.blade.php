<!DOCTYPE html>
<html>
<head>
    <title>Project Report</title>
</head>
<body>
    <h1>Project Report</h1>
    <h2>{{ $project->name }}</h2>
    <p>Completed Tasks: {{ $completedTasks }}</p>
    <p>Pending Tasks: {{ $pendingTasks }}</p>
    <p>Overdue Tasks: {{ $overdueTasks }}</p>
    <hr>
</body>
</html>
