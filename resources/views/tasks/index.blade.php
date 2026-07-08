@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            + Create Task
        </a>
    </div>

    <form action="{{ route('tasks.index') }}" method="GET" class="card card-body mb-4 shadow-sm">
        <div class="form-row align-items-end">
            <div class="col-md-6 form-group mb-0">
                <label for="search" class="small text-muted">Search by title or status</label>
                <input type="text"
                       id="search"
                       name="search"
                       value="{{ $search }}"
                       class="form-control"
                       placeholder="e.g. deploy, pending, completed…">
            </div>
            <div class="col-md-3 form-group mb-0">
                <label for="status" class="small text-muted">Filter by status</label>
                <select id="status" name="status" class="form-control">
                    <option value="">Any</option>
                    <option value="pending"   @selected(request('status') === 'pending')>Pending</option>
                    <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                </select>
            </div>
            <div class="col-md-3 form-group mb-0 d-flex">
                <button type="submit" class="btn btn-secondary mr-2 flex-fill">Apply</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
            </div>
        </div>
    </form>

    @forelse ($tasks as $task)
        <div class="card task-card shadow-sm mb-3 {{ $task->isCompleted() ? 'completed border-success' : 'border-warning' }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="pr-3">
                        <h5 class="mb-1 task-title {{ $task->isCompleted() ? 'completed' : '' }}">
                            {{ $task->title }}
                        </h5>
                        @if ($task->description)
                            <p class="mb-2 text-muted">{{ $task->description }}</p>
                        @endif
                        <small class="text-muted">
                            Created {{ $task->created_at->format('M j, Y g:i A') }}
                        </small>
                    </div>

                    <div class="text-right">
                        @if ($task->isCompleted())
                            <span class="badge badge-success p-2">Completed</span>
                        @else
                            <span class="badge badge-warning p-2">Pending</span>
                        @endif
                    </div>
                </div>

                <hr>

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
        <div class="text-center py-5">
            <p class="lead text-muted mb-3">No tasks yet.</p>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create your first task</a>
        </div>
    @endforelse

    <div class="d-flex justify-content-center">
        {{ $tasks->links() }}
    </div>
@endsection
