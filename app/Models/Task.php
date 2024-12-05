<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_number',
        'task_name',
        'date_created',
        'deadline',
        'important',
        'documents',
        'price',
        
    ];

    protected $casts = [
        'date_created' => 'datetime:Y-m-d',
        'deadline' => 'datetime:Y-m-d',
    ];
}

