<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Customer Details') }}
        </h2>
    </x-slot>

    <style>
        .table td {
            vertical-align: middle;
        }
        .no-tasks-message {
            text-align: center;
            color: #6c757d;
            padding: 20px;
            font-size: 1.2rem;
        }
    </style>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Customer Details Section -->
                    <div class="row mb-4">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="mb-0">{{ __('Personal Details') }}</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>{{ __('First Name:') }}</strong> {{ $customer->first_name }}</p>
                                    <p><strong>{{ __('Last Name:') }}</strong> {{ $customer->last_name }}</p>
                                    <p><strong>{{ __('Email:') }}</strong> {{ $customer->email }}</p>
                                    <p><strong>{{ __('Phone:') }}</strong> {{ $customer->phone }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="mb-0">{{ __('Company Details') }}</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>{{ __('Address:') }}</strong> {{ $customer->address }}</p>
                                    <p><strong>{{ __('Company:') }}</strong> {{ $customer->company ?? '-' }}</p>
                                    <p><strong>{{ __('CUI Firma:') }}</strong> {{ $customer->cui_firma ?? '-' }}</p>
                                    <p><strong>{{ __('Numar Registru Comert:') }}</strong> {{ $customer->numar_registru_comert ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add New Task Section -->
                    <div class="mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-dark text-white">
                                <h4 class="text-lg font-semibold mb-0">{{ __('Add New Task') }}</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('tasks.store', $customer) }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="task_name">{{ __('Task Name') }}</label>
                                        <input type="text" name="task_name" class="form-control" id="task_name" required>
                                        @error('task_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="deadline">{{ __('Deadline') }}</label>
                                        <input type="date" name="deadline" class="form-control" id="deadline">
                                        @error('deadline')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-check mb-3">
                                        <input type="checkbox" name="important" class="form-check-input" id="important">
                                        <label class="form-check-label" for="important">{{ __('Mark as Important') }}</label>
                                    </div>

                                    <div class="form-group">
                                        <label for="documents">{{ __('Upload Documents') }}</label>
                                        <input type="file" id="documents" name="documents[]" class="form-control" multiple>
                                        <div id="selected-files" class="mt-2"></div>
                                        @error('documents.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
                                        <th>{{ __('Date Created') }}</th>
                                        <th>{{ __('Deadline') }}</th>
                                        <th>{{ __('Important') }}</th>
                                        <th>{{ __('Documents') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($customer->tasks as $task)
                                    <tr>
                                        <td class="align-middle">{{ $task->task_number }}</td>
                                        <td class="align-middle">
                                            <form method="POST" action="{{ route('tasks.updateName', $task) }}" id="form-task-name-{{ $task->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="text" name="task_name" value="{{ $task->task_name }}" 
                                                    onblur="document.getElementById('form-task-name-{{ $task->id }}').submit();"
                                                    class="form-control border-0 bg-transparent" />
                                            </form>
                                        </td>
                                        <td class="align-middle">{{ $task->date_created->format('Y-m-d') }}</td>
                                        <td class="align-middle">
                                            <form method="POST" action="{{ route('tasks.updateDeadline', $task) }}" id="form-task-deadline-{{ $task->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="date" name="deadline" value="{{ $task->deadline ? $task->deadline->format('Y-m-d') : '' }}" 
                                                    class="form-control border-0 bg-transparent" />
                                            </form>
                                        </td>
                                        <td class="align-middle">
                                            <form method="POST" action="{{ route('tasks.toggleImportant', $task) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="checkbox" name="important" onchange="this.form.submit()" {{ $task->important ? 'checked' : '' }}>
                                            </form>
                                        </td>
                                        <td class="align-middle">
                                            @if ($task->documents)
                                                <ul>
                                                    @foreach (json_decode($task->documents, true) as $index => $document)
                                                        <li style="display: flex">
                                                            <a href="{{ route('tasks.showDocument', ['file' => basename($document['path'])]) }}" target="_blank">
                                                                {{ $document['name'] }}
                                                            </a>
                                                            <form method="POST" action="{{ route('tasks.deleteDocument', ['task' => $task->id, 'index' => $index]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-danger ml-2">&times;</button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                {{ __('No Documents') }}
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mb-2">Delete</button>
                                            </form>
                                            <!-- Add Documents Button -->
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addDocumentsModal-{{ $task->id }}">
                                                {{ __('Add Documents') }}
                                            </button>

                                            <!-- Add Documents Modal -->
                                            <div class="modal fade" id="addDocumentsModal-{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="addDocumentsModalLabel-{{ $task->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form method="POST" action="{{ route('tasks.addDocuments', $task) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addDocumentsModalLabel-{{ $task->id }}">{{ __('Add Documents to Task') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="documents">{{ __('Select Documents') }}</label>
                                                                    <input type="file" name="documents[]" class="form-control" multiple required>
                                                                    @error('documents.*')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                                <button type="submit" class="btn btn-success">{{ __('Upload') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End of Modal -->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="no-tasks-message text-center">
                                                {{ __('No tasks have been added yet.') }}
                                            </div>
                                        </td>
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
                                <form method="POST" action="{{ route('customers.updateNotes', $customer) }}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <!-- Notes Textarea -->
                                    <div class="form-group">
                                        <label for="notes" class="form-label">{{ __('Add or Update Notes') }}</label>
                                        <textarea class="form-control" name="notes" id="notes" rows="8" placeholder="Enter notes here...">{{ old('notes', $customer->notes) }}</textarea>
                                        @error('notes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Update Button -->
                                    <div class="text-right mt-3">
                                        <button type="submit" class="btn btn-success">
                                            {{ __('Update Notes') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="text-center">
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                            {{ __('Back to Customers') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Include Bootstrap JS (ensure it's included in your layout or add it here) -->
        <!-- If not already included, you can add the following scripts -->
        <!--
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
        -->

        <!-- JavaScript to handle file selection display in Add New Task form -->
        <script>
            const fileInput = document.getElementById('documents');
            const selectedFilesDiv = document.getElementById('selected-files');

            let selectedFiles = [];

            fileInput.addEventListener('change', (event) => {
                const files = event.target.files;

                selectedFiles = []; // Reset the array
                for (let i = 0; i < files.length; i++) {
                    selectedFiles.push(files[i]);
                }

                displaySelectedFiles();
            });

            function displaySelectedFiles() {
                selectedFilesDiv.innerHTML = '';

                selectedFiles.forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'selected-file-item';
                    fileItem.textContent = file.name;

                    const removeButton = document.createElement('button');
                    removeButton.textContent = 'X';
                    removeButton.className = 'btn btn-danger btn-sm ml-2';
                    removeButton.addEventListener('click', () => {
                        removeFile(index);
                    });

                    fileItem.appendChild(removeButton);
                    selectedFilesDiv.appendChild(fileItem);
                });

                // Create a new FileList and assign it to the input element
                updateFileList();
            }

            function removeFile(index) {
                selectedFiles.splice(index, 1);
                displaySelectedFiles();
            }

            function updateFileList() {
                const dataTransfer = new DataTransfer();

                selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });

                fileInput.files = dataTransfer.files;
            }
        </script>
    </x-app-layout>
