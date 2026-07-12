@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <h1 class="h3 page-title mb-1">Create a new task</h1>
                <p class="page-subtitle">Add a task to your board.</p>
            </div>
            <div class="card card-elevated">
                <div class="card-body p-4">
                    <form action="{{ route('tasks.store') }}" method="POST" novalidate>
                        @csrf
                        @include('tasks._form', ['task' => null, 'statuses' => $statuses])

                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-brand px-4">
                                Create Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
