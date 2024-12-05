<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\CustomerDocumentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\CollaboratorTaskController;

Route::patch('/tasks/{task}/update-name', [TaskController::class, 'updateName'])->name('tasks.updateName');
Route::patch('/tasks/{task}/update-deadline', [TaskController::class, 'updateDeadline'])->name('tasks.updateDeadline');
Route::post('/tasks/{task}/add-documents', [TaskController::class, 'addDocuments'])->name('tasks.addDocuments');

Route::get('tasks/documents/{file}', [TaskController::class, 'showDocument'])->name('tasks.showDocument');

Route::delete('/tasks/{task}/documents/{index}', [TaskController::class, 'deleteDocument'])->name('tasks.deleteDocument');

Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::patch('/tasks/{task}/toggle-important', [TaskController::class, 'toggleImportant'])->name('tasks.toggleImportant');

Route::post('/customers/{customer}/tasks', [TaskController::class, 'store'])->name('tasks.store');

Route::get('/customers/{customer}/documents', [CustomerDocumentController::class, 'index'])->name('customers.documents');


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/send-email', [EmailController::class, 'create'])->name('emails.create');
Route::post('/send-email', [EmailController::class, 'send'])->name('emails.send');

Route::middleware('auth')->group(function () {
    Route::resource('calendar', CalendarController::class);
    Route::resource('customers', CustomerController::class);
    // Collaborators Routes
    Route::resource('collaborators', CollaboratorController::class);
    Route::post('collaborators/{collaborator}/tasks', [CollaboratorTaskController::class, 'store'])->name('collaborator-tasks.store');
    Route::delete('collaborators/tasks/{task}', [CollaboratorTaskController::class, 'destroy'])->name('collaborator-tasks.destroy');
    Route::get('/collaborators/create', [CollaboratorController::class, 'create'])->name('collaborators.create');
    Route::post('/collaborators', [CollaboratorController::class, 'store'])->name('collaborators.store');
    Route::get('/collaborators/{collaborator}/edit', [CollaboratorController::class, 'edit'])->name('collaborators.edit');
    Route::put('/collaborators/{collaborator}', [CollaboratorController::class, 'update'])->name('collaborators.update');
    Route::get('/collaborators/{collaborator}', [CollaboratorController::class, 'show'])->name('collaborators.show');
    Route::resource('collaborators', CollaboratorController::class);
    // Route to update collaborator notes
Route::put('/collaborators/{collaborator}/update-notes', [CollaboratorController::class, 'updateNotes'])->name('collaborators.updateNotes');






    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::put('/customers/{customer}/update-notes', [CustomerController::class, 'updateNotes'])->name('customers.updateNotes');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
