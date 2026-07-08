<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status');

        $tasks = Task::query()
            ->search($search)
            ->when(in_array($status, Task::STATUSES, true), fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tasks.index', [
            'tasks'  => $tasks,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('tasks.create', [
            'statuses' => Task::STATUSES,
        ]);
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        Task::query()->create($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', [
            'task'     => $task,
            'statuses' => Task::STATUSES,
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function toggle(Task $task): RedirectResponse
    {
        $task->update([
            'status' => $task->isCompleted()
                ? Task::STATUS_PENDING
                : Task::STATUS_COMPLETED,
        ]);

        return redirect()
            ->route('tasks.index', request()->only(['search', 'status', 'page']))
            ->with('success', 'Task status updated.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
