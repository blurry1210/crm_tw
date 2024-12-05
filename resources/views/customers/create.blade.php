<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Create Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white">
                    <form method="POST" action="{{ route('customers.store') }}" class="space-y-6">
                        @csrf

                        <!-- First Name and Last Name -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block font-medium text-sm text-gray-700">{{ __('First Name') }}</label>
                                <input id="first_name" class="form-input mt-1 block w-full" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus />
                                @error('first_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block font-medium text-sm text-gray-700">{{ __('Last Name') }}</label>
                                <input id="last_name" class="form-input mt-1 block w-full" type="text" name="last_name" value="{{ old('last_name') }}" required />
                                @error('last_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
                            <input id="email" class="form-input mt-1 block w-full" type="email" name="email" value="{{ old('email') }}" required />
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone and Address -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">{{ __('Phone') }}</label>
                                <input id="phone" class="form-input mt-1 block w-full" type="text" name="phone" value="{{ old('phone') }}" />
                                @error('phone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block font-medium text-sm text-gray-700">{{ __('Address') }}</label>
                                <input id="address" class="form-input mt-1 block w-full" type="text" name="address" value="{{ old('address') }}" placeholder="Optional" />
                                @error('address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Company, CUI Firma, and Numar Registru Comert -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Company -->
                            <div>
                                <label for="company" class="block font-medium text-sm text-gray-700">{{ __('Company') }}</label>
                                <input id="company" class="form-input mt-1 block w-full" type="text" name="company" value="{{ old('company') }}" placeholder="Optional" />
                                @error('company')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- CUI Firma -->
                            <div>
                                <label for="cui_firma" class="block font-medium text-sm text-gray-700">{{ __('CUI Firma') }}</label>
                                <input id="cui_firma" class="form-input mt-1 block w-full" type="text" name="cui_firma" value="{{ old('cui_firma') }}" placeholder="Optional" />
                                @error('cui_firma')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Numar Registru Comert -->
                            <div>
                                <label for="numar_registru_comert" class="block font-medium text-sm text-gray-700">{{ __('Numar Registru Comert') }}</label>
                                <input id="numar_registru_comert" class="form-input mt-1 block w-full" type="text" name="numar_registru_comert" value="{{ old('numar_registru_comert') }}" placeholder="Optional" />
                                @error('numar_registru_comert')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Opt-In -->
                        <div class="mt-4">
                            <label for="email_opt_in" class="flex items-center">
                                <input id="email_opt_in" type="checkbox" class="form-checkbox" name="email_opt_in" value="1" {{ old('email_opt_in') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">{{ __('I agree to receive promotional emails.') }}</span>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('customers.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">
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
