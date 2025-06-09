<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Отображает список задач с фильтрацией, поиском и сортировкой.
     *
     * @param \Illuminate\Http\Request $request
     * @param Task|null $task
     * @return View
     */
    public function index(Request $request, ?Task $task = null): View
    {
        $status = $request->query('status');
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');
        $search = $request->query('search');

        $query = auth()->user()->tasks();

        // Фильтрация по статусу
        if ($status && in_array($status, ['pending', 'in_progress', 'completed'])) {
            $query->where('status', $status);
        }

        // Поиск по названию или описанию
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Сортировка
        if (!in_array($sort, ['created_at', 'status'])) {
            $sort = 'created_at';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $tasks = $query->orderBy($sort, $direction)->get();

        return view('task', [
            'task' => $task,
            'tasks' => $tasks,
            'filter_status' => $status,
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search,
        ]);
    }

    /**
     * Создает новую задачу или обновляет существующую.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task = Task::updateOrCreate(
            ['id' => $request->route('task')],
            [
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'user_id' => Auth::id(),
            ]
        );

        return redirect()->route('tasks.index', ['task' => $task]);
    }

    /**
     * Удаляет указанную задачу.
     *
     * @param Task $task
     * @return RedirectResponse
     */
    public function delete(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('index');
    }
}
