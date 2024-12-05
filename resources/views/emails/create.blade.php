<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Send Email to Customers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('emails.send') }}" class="space-y-6">
                        @csrf

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block font-medium text-sm text-gray-700">{{ __('Subject') }}</label>
                            <input id="subject" class="form-input mt-1 block w-full" type="text" name="subject" value="{{ old('subject') }}" required autofocus />
                            @error('subject')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Body -->
                        <div>
                            <label for="body" class="block font-medium text-sm text-gray-700">{{ __('Body') }}</label>
                            <textarea id="body" class="form-textarea mt-1 block w-full" name="body" rows="5" required>{{ old('body') }}</textarea>
                            @error('body')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Select All Checkbox -->
                        <div class="flex items-center mt-4">
                            <input type="checkbox" id="select-all" class="form-checkbox h-5 w-5 text-blue-600" />
                            <label for="select-all" class="ml-2 block text-sm text-gray-700 font-medium">{{ __('Select All Customers') }}</label>
                        </div>

                        <!-- Customers -->
                        <div>
                            <label for="customers" class="block font-medium text-sm text-gray-700 mt-4">{{ __('Select Customers') }}</label>
                            <select id="customers" class="form-multiselect mt-1 block w-full" name="customers[]" multiple>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->email }})</option>
                                @endforeach
                            </select>
                            @error('customers')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Send Email Button -->
                        <div class="mt-6 flex justify-between">
                            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                {{ __('Send Email') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const customerSelect = document.getElementById('customers');

            selectAllCheckbox.addEventListener('change', function () {
                const isChecked = selectAllCheckbox.checked;
                for (let i = 0; i < customerSelect.options.length; i++) {
                    customerSelect.options[i].selected = isChecked;
                }
            });
        });
    </script>
</x-app-layout>
