<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaborator;
use App\Models\CollaboratorTask;

class CollaboratorTaskController extends Controller
{
    // Store documents method
    public function storeDocuments(Request $request)
    {
        $documents = [];

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                // Store the file in the 'public/documents' directory
                $filePath = $file->store('documents', 'public');

                // Store the original filename and path
                $documents[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $filePath,
                ];
            }
        }

        // Return as a JSON-encoded array
        return json_encode($documents);
    }

    // Store a new task for a collaborator
    public function store(Request $request, Collaborator $collaborator)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'deadline' => 'nullable|date',
            'important' => 'boolean',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpg,png',
        ]);

        // Create the task and store documents (if any)
        $collaborator->tasks()->create([
            'task_name' => $request->task_name,
            'price' => $request->price,
            'date_created' => now(), // Current date
            'deadline' => $request->deadline,
            'important' => $request->boolean('important'), // Simplified handling of boolean field
            'documents' => $this->storeDocuments($request), // Store and handle documents
        ]);

        return redirect()->route('collaborators.show', $collaborator)->with('success', 'Task added successfully.');
    }

    // Delete a task
    public function destroy(CollaboratorTask $task)
    {
        // Delete the task
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}
