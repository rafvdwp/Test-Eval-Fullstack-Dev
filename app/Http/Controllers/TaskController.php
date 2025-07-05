<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => Task::all(),
            'manager' => Task::where('created_by', $user->id)
                              ->orWhere('assigned_to', $user->id)
                              ->get(),
            default => Task::where('assigned_to', $user->id)
                            ->orWhere('created_by', $user->id)
                            ->get()
        };
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date'
        ]);

        $assignedUser = User::find($request->assigned_to);

        if (Gate::denies('assign-tasks', $assignedUser)) {
            return response()->json(['message' => 'You are not allowed to assign this task.'], 403);
        }

        $task = Task::create([
            'id' => (string) Str::uuid(),
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'status' => 'pending',
            'due_date' => $request->due_date,
            'created_by' => Auth::id(),
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        if ($task->created_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'status' => 'sometimes|required|in:pending,in_progress,done',
            'due_date' => 'sometimes|required|date'
        ]);

        $task->update($request->only('title', 'description', 'status', 'due_date'));

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $task->created_by !== Auth::id()) {
            abort(403);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}