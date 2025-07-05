<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CheckOverdueTasks extends Command
{
    protected $signature = 'tasks:check-overdue';
    protected $description = 'Check overdue tasks and log them';

    public function handle()
    {
        $now = Carbon::now();

        $overdueTasks = Task::whereIn('status', ['pending', 'in_progress'])
            ->where('due_date', '<', $now)
            ->get();

        foreach ($overdueTasks as $task) {
            ActivityLog::create([
                'id' => (string) Str::uuid(),
                'user_id' => $task->assigned_to,
                'action' => 'task_overdue',
                'description' => 'Task overdue: ' . $task->id,
                'logged_at' => now(),
            ]);

            $this->info("Logged overdue task: {$task->id}");
        }

        $this->info('Overdue task check complete.');
    }
}
