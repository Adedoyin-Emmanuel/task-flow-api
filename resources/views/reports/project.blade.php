<!DOCTYPE html>
<html>
<head>
    <title>All Projects Report</title>
</head>
<body>
    <h1>All Projects Report</h1>
    @foreach($projects as $summary)
        <h2>{{ $summary['project']->name }}</h2>
        <p>Completed Tasks: {{ $summary['completedTasks'] }}</p>
        <p>Pending Tasks: {{ $summary['pendingTasks'] }}</p>
        <p>Overdue Tasks: {{ $summary['overdueTasks'] }}</p>
        <hr>
    @endforeach
</body>
</html>
