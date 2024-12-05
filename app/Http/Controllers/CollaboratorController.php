<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaborator;

class CollaboratorController extends Controller
{
    // Display a list of collaborators
    public function index(Request $request)
    {
        $query = Collaborator::query();

        // Search functionality if search term is provided
        if ($search = $request->get('search')) {
            $query->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        }

        // Pagination
        $collaborators = $query->paginate(10);

        // Returning the index view with the list of collaborators
        return view('collaborators.index', compact('collaborators'));
    }

    // Display a single collaborator
    public function show(Collaborator $collaborator)
    {
        // Returning the view for a specific collaborator
        return view('collaborators.show', compact('collaborator'));
    }

    // Show the form for creating a new collaborator
    public function create()
    {
        // Returning the create form view
        return view('collaborators.create');
    }

    // Store a new collaborator in the database
    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z-]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z-]+$/',
            'email' => 'required|string|email|max:255|unique:collaborators',
            'phone' => 'required|string|max:255|regex:/^\+?[0-9 ]+$/',
        ], [
            // Custom error messages
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'First name should contain only letters and hyphens.',
            'last_name.required' => 'Last name is required.',
            'last_name.regex' => 'Last name should contain only letters and hyphens.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already taken.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number should contain only numbers, spaces, and an optional leading +.',
        ]);

        // Creating a new collaborator using validated data
        Collaborator::create($request->only('first_name', 'last_name', 'email', 'phone'));

        // Redirecting to the index route with a success message
        return redirect()->route('collaborators.index')->with('success', 'Collaborator created successfully.');
    }

    // Show the form for editing a collaborator
    public function edit(Collaborator $collaborator)
    {
        // Returning the edit form view
        return view('collaborators.edit', compact('collaborator'));
    }

    // Update a collaborator's details
    public function update(Request $request, Collaborator $collaborator)
    {
        // Validation rules for updating collaborator details
        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z-]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z-]+$/',
            'email' => 'required|string|email|max:255|unique:collaborators,email,' . $collaborator->id,
            'phone' => 'required|string|max:255|regex:/^\+?[0-9 ]+$/',
        ], [
            // Custom error messages for update
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'First name should contain only letters and hyphens.',
            'last_name.required' => 'Last name is required.',
            'last_name.regex' => 'Last name should contain only letters and hyphens.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already taken.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number should contain only numbers, spaces, and an optional leading +.',
        ]);

        // Updating the collaborator with validated data
        $collaborator->update($request->only('first_name', 'last_name', 'email', 'phone'));

        // Redirecting to the index route with a success message
        return redirect()->route('collaborators.index')->with('success', 'Collaborator updated successfully.');
    }

    // Delete a collaborator
    public function destroy(Collaborator $collaborator)
    {
        // Deleting the collaborator
        $collaborator->delete();

        // Redirecting to the index route with a success message
        return redirect()->route('collaborators.index')->with('success', 'Collaborator deleted successfully.');
    }

    public function updateNotes(Request $request, Collaborator $collaborator)
    {
        // Validate notes input
        $request->validate([
            'notes' => 'nullable|string',
        ]);
    
        // Update collaborator's notes
        $collaborator->update([
            'notes' => $request->input('notes'),
        ]);
    
        // Redirect back to collaborator details with a success message
        return redirect()->route('collaborators.show', $collaborator)->with('success', 'Notes updated successfully!');
    }
    

}
