<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $task?->title ?? 'New task' }}</title>
</head>
<body>
    <h1>{{ $task?->title ?? 'New task' }}</h1>
    <p>Welcome to the task manager application!</p>

    {{-- Форма поиска, фильтрации и сортировки --}}
    <form method="GET" action="{{ route('tasks.index') }}" style="display: flex; gap: 1em; align-items: flex-end; margin-bottom: 2em;">
        <div>
            <label for="search">Поиск:</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Название или описание">
        </div>
        <div>
            <label for="status">Фильтр по статусу:</label>
            <select name="status" id="status">
                <option value="">Все</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Ожидает</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>В процессе</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Завершено</option>
            </select>
        </div>
        <div>
            <label for="sort">Сортировать по:</label>
            <select name="sort" id="sort">
                <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Дате создания</option>
                <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Статусу</option>
            </select>
            <select name="direction" id="direction">
                <option value="asc" {{ request('direction', 'desc') == 'asc' ? 'selected' : '' }}>По возрастанию</option>
                <option value="desc" {{ request('direction', 'desc') == 'desc' ? 'selected' : '' }}>По убыванию</option>
            </select>
        </div>
        <div>
            <button type="submit">Применить</button>
        </div>
    </form>

    {{-- Форма создания или редактирования задачи --}}
    <form action="{{ route('tasks.index', ['task' => $task?->id]) }}" method="POST" style="margin-bottom: 2em;">
        @csrf
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="{{ old('title', $task->title ?? '') }}" required>
        <br><br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required>{{ old('description', $task->description ?? '') }}</textarea>
        <br><br>
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="pending" {{ (old('status', $task->status ?? '') == 'pending') ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ (old('status', $task->status ?? '') == 'in_progress') ? 'selected' : '' }}>In progress</option>
            <option value="completed" {{ (old('status', $task->status ?? '') == 'completed') ? 'selected' : '' }}>Completed</option>
        </select>
        <br><br>
        <button type="submit">{{ $task ? 'Update' : 'Create' }} task</button>
        <br><br>
        <a href="{{ route('index') }}">Back to tasks</a>
    </form>

    {{-- Список задач --}}
    <h2>Ваши задачи</h2>
    <ul>
        @forelse ($tasks as $item)
            <li>
                <b>{{ $item->title }}</b>
                - {{ $item->status }}
                | <a href="{{ route('tasks.index', $item->id) }}">View</a>
                | <a href="{{ route('tasks.delete', $item->id) }}">Delete</a>
                <div>{{ $item->description }}</div>
            </li>
        @empty
            <li>Задач не найдено.</li>
        @endforelse
    </ul>
</body>
</html>

