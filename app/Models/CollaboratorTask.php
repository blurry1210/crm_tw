<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaboratorTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborator_id',
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

    // Relationship with Collaborator
    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class);
    }
}
