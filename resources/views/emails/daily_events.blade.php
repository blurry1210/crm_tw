<!DOCTYPE html>
<html>
<head>
    <title>Daily Events</title>
</head>
<body>
    <h1>Events for Tomorrow</h1>
    <ul>
        @foreach ($events as $event)
            <li>{{ $event->title }} - {{ $event->date }} {{ $event->start_time }} to {{ $event->end_time }}</li>
        @endforeach
    </ul>
</body>
</html>
