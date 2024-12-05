<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Collaborator Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Collaborator Details -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Personal Information') }}</h3>
                        <p><strong>{{ __('First Name:') }}</strong> {{ $collaborator->first_name }}</p>
                        <p><strong>{{ __('Last Name:') }}</strong> {{ $collaborator->last_name }}</p>
                        <p><strong>{{ __('Email:') }}</strong> {{ $collaborator->email }}</p>
                        <p><strong>{{ __('Phone:') }}</strong> {{ $collaborator->phone }}</p>
                    </div>

                    <!-- Add Task Section -->
                    <div class="mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-dark text-white">
                                <h4 class="text-lg font-semibold mb-0">{{ __('Add New Task') }}</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('collaborator-tasks.store', $collaborator) }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="task_name">{{ __('Task Name') }}</label>
                                        <input type="text" name="task_name" class="form-control" id="task_name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="price">{{ __('Price') }}</label>
                                        <input type="number" name="price" class="form-control" id="price" step="0.01" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="deadline">{{ __('Deadline') }}</label>
                                        <input type="date" name="deadline" class="form-control" id="deadline">
                                    </div>

                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="important" class="form-check-input" id="important">
                                        <label class="form-check-label" for="important">{{ __('Mark as Important') }}</label>
                                    </div>

                                    <div class="form-group">
                                        <label for="documents">{{ __('Upload Documents') }}</label>
                                        <input type="file" id="documents" name="documents[]" class="form-control" multiple>
                                    </div>

                                    <button type="submit" class="btn btn-primary">{{ __('Add Task') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>

                                    <!-- Tasks Section -->
                                    <div class="mb-4">
                        <h4 class="text-lg font-semibold">{{ __('Tasks') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>{{ __('Task Number') }}</th>
                                        <th>{{ __('Task Name') }}</th>
                                        <th>{{ __('Price') }}</th> <!-- Price Column -->
                                        <th>{{ __('Date Created') }}</th>
                                        <th>{{ __('Deadline') }}</th>
                                        <th>{{ __('Important') }}</th>
                                        <th>{{ __('Documents') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($collaborator->tasks as $task)
                                        <tr>
                                            <td class="align-middle">{{ $task->id }}</td>
                                            <td class="align-middle">{{ $task->task_name }}</td>
                                            <td class="align-middle">{{ $task->price }}</td> <!-- Display Price -->
                                            <td class="align-middle">{{ $task->date_created->format('Y-m-d') }}</td>
                                            <td class="align-middle">{{ $task->deadline ? $task->deadline->format('Y-m-d') : '-' }}</td>
                                            <td class="align-middle">{{ $task->important ? 'Yes' : 'No' }}</td>
                                            <td class="align-middle">
                                                @if ($task->documents)
                                                    <ul>
                                                        @foreach (json_decode($task->documents, true) as $document)
                                                            <li>
                                                                <a href="{{ route('tasks.showDocument', ['file' => basename($document['path'])]) }}" target="_blank">{{ $document['name'] }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{ __('No Documents') }}
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <form method="POST" action="{{ route('collaborator-tasks.destroy', $task) }}" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm mb-2">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">{{ __('No tasks available.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-dark text-white">
                                <h4 class="mb-0">{{ __('Notes') }}</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('collaborators.updateNotes', $collaborator) }}">
                                    @csrf
                                    @method('PUT')

                                    <!-- Notes Textarea -->
                                    <div class="form-group">
                                        <label for="notes" class="form-label">{{ __('Add or Update Notes') }}</label>
                                        <textarea class="form-control" name="notes" id="notes" rows="8" placeholder="Enter notes here...">{{ old('notes', $collaborator->notes) }}</textarea>
                                        @error('notes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Update Button -->
                                    <div class="text-right mt-3">
                                        <button type="submit" class="btn btn-success">{{ __('Update Notes') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- Back Button -->
                    <div class="text-center">
                        <a href="{{ route('collaborators.index') }}" class="btn btn-secondary">
                            {{ __('Back to Collaborators') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

