@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <h1 class="h3 page-title mb-1">Edit task</h1>
                <p class="page-subtitle">Update the details below.</p>
            </div>
            <div class="card card-elevated">
                <div class="card-body p-4">
                    <form action="{{ route('tasks.update', $task) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')
                        @include('tasks._form', ['task' => $task, 'statuses' => $statuses])

                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-brand px-4">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
