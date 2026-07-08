@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h1 class="h4 mb-0">Edit task</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.update', $task) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')
                        @include('tasks._form', ['task' => $task, 'statuses' => $statuses])

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
