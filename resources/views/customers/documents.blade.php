<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Documents for ') . $customer->first_name . ' ' . $customer->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Tasks and Documents') }}</h3>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th scope="col">{{ __('Task Name') }}</th>
                                    <th scope="col">{{ __('Documents') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customer->tasks as $task)
                                    <tr>
                                        <td class="align-middle"><strong>{{ $task->task_name }}</strong></td>
                                        <td class="align-middle">
                                            @if ($task->documents)
                                                <ul class="list-unstyled mb-0">
                                                    @foreach (json_decode($task->documents, true) as $document)
                                                        <li>
                                                            <a href="{{ route('tasks.showDocument', ['file' => basename($document['path'])]) }}" target="_blank">
                                                                {{ $document['name'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">{{ __('No Documents') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">
                                            {{ __('No tasks or documents available.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-4 text-center">
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
    </div>
</x-app-layout>
