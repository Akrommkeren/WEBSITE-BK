<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'project_id',
        'service_category',
        'transaction_date',
        'target_date',
        'attachment',
        'client_notes',
        'admin_notes',
        'status',
        'progress_notes',
        'completion_docs',
        'completion_url',
        'staff_notes',
    ];
}
