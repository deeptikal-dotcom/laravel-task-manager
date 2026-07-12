@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')
    @php
        $totalCount     = \App\Models\Task::count();
        $completedCount = \App\Models\Task::where('status', \App\Models\Task::STATUS_COMPLETED)->count();
        $pendingCount   = $totalCount - $completedCount;
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 page-title mb-1">Tasks</h1>
            <p class="page-subtitle">Manage and track your work in one place.</p>
        </div>
        <a href="{{ route('tasks.create') }}" class="btn btn-brand">
            + Create Task
        </a>
    </div>

    {{-- Summary cards --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card card-elevated stat-card stat-total h-100">
                <div class="card-body">
                    <div class="stat-label">Total Tasks</div>
                    <div class="stat-value">{{ $totalCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card card-elevated stat-card stat-done h-100">
                <div class="card-body">
                    <div class="stat-label">Completed</div>
                    <div class="stat-value text-success">{{ $completedCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-elevated stat-card stat-pending h-100">
                <div class="card-body">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value" style="color:#f0ad4e;">{{ $pendingCount }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search / filter --}}
    <form action="{{ route('tasks.index') }}" method="GET" class="card card-elevated card-body mb-4">
        <div class="form-row align-items-end">
            <div class="col-md-6 form-group mb-2 mb-md-0">
                <label for="search" class="small text-muted mb-1">Search by title or status</label>
                <input type="text"
                       id="search"
                       name="search"
                       value="{{ $search }}"
                       class="form-control"
                       placeholder="e.g. deploy, pending, completed…">
            </div>
            <div class="col-md-3 form-group mb-2 mb-md-0">
                <label for="status" class="small text-muted mb-1">Filter by status</label>
                <select id="status" name="status" class="form-control">
                    <option value="">Any</option>
                    <option value="pending"   @selected(request('status') === 'pending')>Pending</option>
                    <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                </select>
            </div>
            <div class="col-md-3 form-group mb-0 d-flex">
                <button type="submit" class="btn btn-outline-brand mr-2 flex-fill">Apply</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
            </div>
        </div>
    </form>

    @forelse ($tasks as $task)
        <div class="card card-elevated task-card mb-3 {{ $task->isCompleted() ? 'completed' : '' }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="pr-3">
                        <h5 class="mb-1 task-title {{ $task->isCompleted() ? 'completed' : '' }}">
                            @if ($task->isCompleted())
                                <span class="task-check" aria-hidden="true">&#10003;</span>
                            @endif
                            {{ $task->title }}
                        </h5>
                        @if ($task->description)
                            <p class="mb-2 text-muted">{{ $task->description }}</p>
                        @endif
                        <span class="task-meta">
                            Created {{ $task->created_at->format('M j, Y g:i A') }}
                        </span>
                    </div>

                    <div class="text-right">
                        @if ($task->isCompleted())
                            <span class="badge badge-pill badge-success badge-pill-lg">Completed</span>
                        @else
                            <span class="badge badge-pill badge-warning badge-pill-lg">Pending</span>
                        @endif
                    </div>
                </div>

                <div class="task-divider"></div>

                <div class="d-flex flex-wrap">
                    <form action="{{ route('tasks.toggle', $task) }}"
                          method="POST"
                          class="mr-2 mb-1">
                        @csrf
                        <button type="submit"
                                class="btn btn-sm {{ $task->isCompleted() ? 'btn-outline-warning' : 'btn-outline-success' }}">
                            {{ $task->isCompleted() ? 'Mark Pending' : 'Mark Completed' }}
                        </button>
                    </form>

                    <a href="{{ route('tasks.edit', $task) }}"
                       class="btn btn-sm btn-outline-primary mr-2 mb-1">
                        Edit
                    </a>

                    <button type="button"
                            class="btn btn-sm btn-outline-danger mb-1"
                            data-toggle="modal"
                            data-target="#deleteModal-{{ $task->id }}">
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade"
             id="deleteModal-{{ $task->id }}"
             tabindex="-1"
             role="dialog"
             aria-labelledby="deleteModalLabel-{{ $task->id }}"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel-{{ $task->id }}">
                            Delete task?
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete
                        <strong>"{{ $task->title }}"</strong>? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-icon">&#128203;</div>
            <h5 class="mb-1">No tasks found</h5>
            <p class="text-muted mb-3">
                @if ($search || request('status'))
                    Nothing matches your current search or filter.
                @else
                    You haven't created any tasks yet.
                @endif
            </p>
            @if ($search || request('status'))
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Clear filters</a>
            @else
                <a href="{{ route('tasks.create') }}" class="btn btn-brand">Create your first task</a>
            @endif
        </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $tasks->links() }}
    </div>
@endsection
