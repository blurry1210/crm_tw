<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Edit Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white">
                    <form id="eventEditForm" method="POST" action="{{ route('calendar.update', $calendar->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Date -->
                        <div>
                            <label for="date" class="block font-medium text-sm text-gray-700">{{ __('Date') }}</label>
                            <input id="date" class="form-input mt-1 block w-full" type="date" name="date" value="{{ old('date', $calendar->date) }}" min="{{ now()->format('Y-m-d') }}" required />
                            @error('date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Start Time and End Time -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Start Time -->
                            <div>
                                <label for="start_time" class="block font-medium text-sm text-gray-700">{{ __('Start Time') }}</label>
                                <input id="start_time" class="form-input mt-1 block w-full" type="time" name="start_time" value="{{ old('start_time', $calendar->start_time) }}" required />
                                @error('start_time')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- End Time -->
                            <div>
                                <label for="end_time" class="block font-medium text-sm text-gray-700">{{ __('End Time') }}</label>
                                <input id="end_time" class="form-input mt-1 block w-full" type="time" name="end_time" value="{{ old('end_time', $calendar->end_time) }}" required />
                                @error('end_time')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Customer -->
                        <div>
                            <label for="customer_id" class="block font-medium text-sm text-gray-700">{{ __('Customer') }}</label>
                            <select id="customer_id" name="customer_id" class="form-select mt-1 block w-full">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $calendar->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->first_name }} {{ $customer->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('calendar.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                                {{ __('Update Event') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Validation -->
    <script>
        document.getElementById('eventEditForm').addEventListener('submit', function(event) {
            var startTime = document.getElementById('start_time').value;
            var endTime = document.getElementById('end_time').value;

            if (endTime <= startTime) {
                event.preventDefault(); // Prevent form submission
                alert('End time must be later than start time.');
            }
        });

        // Ensure the min date is set dynamically to today's date
        document.getElementById('date').min = new Date().toISOString().split('T')[0];
    </script>
</x-app-layout>
