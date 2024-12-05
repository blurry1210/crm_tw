<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Add Collaborator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white">
                    <form method="POST" action="{{ route('collaborators.store') }}" class="space-y-6">
                        @csrf

                        <!-- First Name and Last Name -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block font-medium text-sm text-gray-700">{{ __('First Name') }}</label>
                                <input id="first_name" class="form-input mt-1 block w-full" type="text" name="first_name" required autofocus />
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block font-medium text-sm text-gray-700">{{ __('Last Name') }}</label>
                                <input id="last_name" class="form-input mt-1 block w-full" type="text" name="last_name" required />
                            </div>
                        </div>

                        <!-- Email and Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
                                <input id="email" class="form-input mt-1 block w-full" type="email" name="email" required />
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">{{ __('Phone') }}</label>
                                <input id="phone" class="form-input mt-1 block w-full" type="text" name="phone" required />
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('collaborators.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-150 ease-in-out">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
