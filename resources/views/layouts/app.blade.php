<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Task Manager') &middot; youbloom</title>

    {{-- Bootstrap 4.6.2 (served from jsDelivr; stackpath BootstrapCDN was retired) --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
          crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<nav class="navbar navbar-expand yb-navbar shadow-sm">
    <div class="container yb-shell">
        <a class="navbar-brand" href="{{ route('tasks.index') }}">
            <span class="yb-brand-mark">&#9835;</span>&nbsp;<span class="yb-brand-you">you</span><span class="yb-brand-mark">bloom</span>
            <small class="ml-2 d-none d-sm-inline">Task Manager</small>
        </a>
        <a href="{{ route('tasks.create') }}" class="btn btn-brand btn-sm ml-auto">
            + New Task
        </a>
    </div>
</nav>

<main class="container yb-shell py-4">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <strong>&#10003;</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <strong>Whoops!</strong> Please fix the following:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @yield('content')
</main>

<footer class="container yb-shell text-center yb-footer py-4">
    Built for the youbloom Laravel practical test.
</footer>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>

@yield('scripts')
</body>
</html>
