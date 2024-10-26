<!DOCTYPE html>
<html>
<head>
    <title>Upcoming Event Reminder</title>
</head>
<body>
    <h1>Reminder: {{ $event->title }}</h1>
    <p>{{ $event->description }}</p>
    <p>Start Time: {{ $event->start_datetime }}</p>
    <p>End Time: {{ $event->end_datetime }}</p>
</body>
</html>
