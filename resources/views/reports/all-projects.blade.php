<!DOCTYPE html>
<html>
<head>
    <title>Project Report</title>
</head>
<body>
    <h1>{{ $project->name }} Report</h1>
    <p>Completed Tasks: {{ $completedTasks }}</p>
    <p>Pending Tasks: {{ $pendingTasks }}</p>
    <p>Overdue Tasks: {{ $overdueTasks }}</p>
</body>
</html>
