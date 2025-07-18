<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'action',
        'description',
        'logged_at'
    ];
}
