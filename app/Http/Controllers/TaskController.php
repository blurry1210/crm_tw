<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class TaskController extends Controller
{
    public function create(Customer $customer)
    {
        return view('tasks.create', compact('customer'));
    }

    public function store(Request $request, Customer $customer)
    {
        // Convert 'important' to a boolean value before validation
        $validated = $request->merge([
            'important' => $request->has('important') ? true : false,
        ])->validate([
            'task_name' => 'required|string|max:255',
            'deadline' => 'nullable|date',  // Make deadline optional
            'important' => 'boolean',
            'documents.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg', // Example for file types
        ]);

        $taskNumber = $customer->tasks()->max('task_number') + 1;

        $task = new Task();
        $task->customer_id = $customer->id;
        $task->task_number = $taskNumber;
        $task->task_name = $validated['task_name'];
        $task->date_created = now();
        $task->deadline = $validated['deadline'];
        $task->important = $validated['important']; // Now it will be either true or false

        if ($request->hasFile('documents')) {
            $documents = [];
            foreach ($request->file('documents') as $document) {
                $originalName = $document->getClientOriginalName();
                $storedPath = $document->store('tasks/documents', 'private');
                
                $documents[] = [
                    'name' => $originalName,
                    'path' => $storedPath
                ];
            }
            $task->documents = json_encode($documents);
        }

        $task->save();

        return redirect()->route('customers.show', $customer)->with('success', 'Task added successfully!');
    }
    public function showDocument($file)
    {
        $path = storage_path('app/private/tasks/documents/' . $file);

        if (!File::exists($path)) {
            abort(404);
        }
        $fileContent = File::get($path);
        $fileContent = File::get($path);
        $type = File::mimeType($path);

        $response = response($fileContent, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function updateName(Request $request, Task $task)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
        ]);

        $task->task_name = $request->task_name;
        $task->save();

        return back()->with('success', 'Task name updated successfully!');
    }

    public function updateDeadline(Request $request, Task $task)
    {
        $request->validate([
            'deadline' => 'nullable|date',
        ]);

        $task->deadline = $request->deadline;
        $task->save();

        return back()->with('success', 'Deadline updated successfully!');
    }

    public function addDocuments(Request $request, Task $task)
    {
        $request->validate([
            'documents.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:2048',
        ]);

        $documents = json_decode($task->documents, true) ?? [];

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $originalName = $document->getClientOriginalName();
                $storedPath = $document->store('tasks/documents', 'private');

                $documents[] = [
                    'name' => $originalName,
                    'path' => $storedPath,
                ];
            }

            $task->documents = json_encode($documents);
            $task->save();
        }

        return back()->with('success', 'Documents added successfully!');
    }




    public function toggleImportant(Task $task)
    {
        $task->important = !$task->important;
        $task->save();

        return back()->with('success', 'Task importance updated.');
    }
    public function destroy(Task $task)
    {
        // Delete associated documents if needed
        if ($task->documents) {
            foreach (json_decode($task->documents) as $document) {
                Storage::delete($document->path);
            }
        }

        $task->delete();

        return back()->with('success', 'Task deleted successfully.');
    }

    public function deleteDocument(Task $task, $index)
    {
        $documents = json_decode($task->documents, true);
        
        // Remove the document at the specified index
        unset($documents[$index]);

        // Re-index the array to avoid gaps
        $documents = array_values($documents);

        // If the documents array is empty, set it to null
        if (empty($documents)) {
            $task->documents = null;
        } else {
            // Otherwise, re-encode it to JSON
            $task->documents = json_encode($documents);
        }

        $task->save();

        return back()->with('success', 'Document deleted successfully.');
    }


}
