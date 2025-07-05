<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-light bg-white shadow-sm mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="navbar-brand mb-0 h4">Dashboard</span>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <h4 class="mb-4">Your Tasks</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($tasks->isEmpty())
        <p class="text-muted">No tasks available.</p>
    @else
        <div class="row g-3">
            @foreach($tasks as $task)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5>{{ $task->title }}</h5>
                            <p>{{ $task->description }}</p>
                            <span class="badge bg-{{ 
                                $task->status === 'pending' ? 'secondary' : 
                                ($task->status === 'in_progress' ? 'warning' : 
                                ($task->status === 'done' ? 'success' : 'dark'))
                            }}">{{ $task->status }}</span>
                            <small class="d-block mt-2 text-muted">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</small>

                            {{-- Edit/Delete hanya jika user adalah pemilik atau admin --}}
                            @if(auth()->user()->id === $task->user_id || auth()->user()->role === 'admin')
                                <div class="mt-3 d-flex justify-content-between">
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>
