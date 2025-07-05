<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Gate;

class LogController extends Controller
{
    public function index()
    {
        if (Gate::denies('viewLogs')) {
            abort(403);
        }

        return ActivityLog::latest()->get();
    }
}