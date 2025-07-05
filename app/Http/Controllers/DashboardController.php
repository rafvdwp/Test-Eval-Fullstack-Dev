<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $tasks = Task::query();

        if ($user->role === 'manager' || $user->role === 'staff') {
            $tasks->where('user_id', $user->id); // hanya task miliknya
        }

        return view('dashboard', [
            'tasks' => $tasks->latest()->get()
        ]);
    }
}
