<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Projects Report</title>
</head>
<body>
    <h1>All Projects Report</h1>
    @foreach($projects as $summary)
        <h2>{{ $summary['project']->name }} Report</h2>
        <p>Completed Tasks: {{ $summary['completedTasks'] }}</p>
        <p>Pending Tasks: {{ $summary['pendingTasks'] }}</p>
        <p>Overdue Tasks: {{ $summary['overdueTasks'] }}</p>
        <hr>
    @endforeach
</body>
</html>
