<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task manager</title>
</head>
<body>
    <h1>Task manager</h1>
    <p>Welcome to the task manager application!</p>
    @auth
        <p>Hello, {{ auth()->user()->name }}!</p>
        <ul>
            <li><a href="{{ route('logout') }}">Logout</a></li>
        </ul>
    @else
        <p>To get started, please register or log in.</p>
        <ul>
            <li><a href="{{ route('register') }}">Register</a></li>
            <li><a href="{{ route('login') }}">Login</a></li>
        </ul>
    @endauth

    <h2>Tasks</h2>
    @auth
        @if (auth() -> user() -> tasks() -> count() > 0)
            <ul>
                @foreach (auth()->user()->tasks as $task)
                    <li>
                        <h3>
                            <b>{{ $task->title }}</b>
                            -
                            {{ $task->status }}
                            |
                            <a href="{{ route('tasks.index', $task -> id) }}">View</a>
                            <a href="{{ route('tasks.delete', $task -> id) }}">Delete</a>
                        </h3>
                        <p>{{ $task->description }}</p>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('tasks.index') }}">Create a new task</a></p>
        @else
            <p>You have no tasks yet. <a href="{{ route('tasks.index') }}">Create a new task</a></p>
        @endif
    @else
        <p>You need to be logged in to see your tasks.</p>
    @endauth
</body>
</html>
