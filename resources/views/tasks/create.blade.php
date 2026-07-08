@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h1 class="h4 mb-0">Create a new task</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.store') }}" method="POST" novalidate>
                        @csrf
                        @include('tasks._form', ['task' => null, 'statuses' => $statuses])

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Create Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
