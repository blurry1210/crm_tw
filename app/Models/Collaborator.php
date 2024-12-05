<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{

    // In Collaborator.php (Collaborator model)
public function tasks()
{
    return $this->hasMany(CollaboratorTask::class); // Or Task::class if using one model
}


    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'notes',
        // You can remove 'projects' from here if you will manage them separately.
    ];

    // If you will handle projects as a separate relationship:
    // public function projects()
    // {
    //     return $this->hasMany(Project::class); // Assuming you have a Project model
    // }
}
