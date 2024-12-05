<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Collaborators') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Add Collaborator Button and Search Form -->
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                        <a href="{{ route('collaborators.create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded mb-4 md:mb-0">
                            {{ __('Add Collaborator') }}
                        </a>

                        <!-- Search Form -->
                        <form method="GET" action="{{ route('collaborators.index') }}" class="w-full md:w-auto flex items-center">
                            <input type="text" name="search" placeholder="Search..." class="border rounded-l py-2 px-4 w-full md:w-auto" value="{{ request()->get('search') }}">
                            <button type="submit" class="bg-blue-500 text-white rounded-r px-4 py-2">
                                {{ __('Search') }}
                            </button>
                        </form>
                    </div>

                    <!-- Collaborators Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">{{ __('First Name') }}</th>
                                    <th class="px-4 py-2">{{ __('Last Name') }}</th>
                                    <th class="px-4 py-2">{{ __('Email') }}</th>
                                    <th class="px-4 py-2">{{ __('Phone') }}</th>
                                    <th class="px-4 py-2">{{ __('Company') }}</th>
                                    <th class="px-4 py-2">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collaborators as $collaborator)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $collaborator->first_name }}</td>
                                        <td class="px-4 py-2">{{ $collaborator->last_name }}</td>
                                        <td class="px-4 py-2">{{ $collaborator->email }}</td>
                                        <td class="px-4 py-2">{{ $collaborator->phone }}</td>
                                        <td class="px-4 py-2">{{ $collaborator->company }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <div class="relative inline-block text-left">
                                                <button type="button" onclick="toggleDropdown(event, 'dropdown-{{ $collaborator->id }}')" class="menu-button inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-2 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                                                    <!-- Icon -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M6 10a2 2 0 114 0 2 2 0 01-4 0zM10 18a2 2 0 110-4 2 2 0 010 4zm0-12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                                <div id="dropdown-{{ $collaborator->id }}" class="origin-top-right absolute right-0 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 hidden">
                                                    <div class="py-1">
                                                        <a href="{{ route('collaborators.show', $collaborator) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('View') }}</a>
                                                        <a href="{{ route('collaborators.edit', $collaborator) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Edit') }}</a>
                                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Documents') }}</a>
                                                        <form action="{{ route('collaborators.destroy', $collaborator) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this collaborator?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Delete') }}</button>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($collaborators->isEmpty())
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                                            {{ __('No collaborators found.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-6">
                        {{ $collaborators->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- JavaScript -->
<script>
    function toggleDropdown(event, dropdownId) {
        event.preventDefault();
        var dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');

        // Close other open dropdowns
        var dropdowns = document.querySelectorAll('.origin-top-right');
        dropdowns.forEach(function(otherDropdown) {
            if (otherDropdown.id !== dropdownId) {
                otherDropdown.classList.add('hidden');
            }
        });

        event.stopPropagation();
    }

    // Close dropdowns when clicking outside
    window.addEventListener('click', function() {
        var dropdowns = document.querySelectorAll('.origin-top-right');
        dropdowns.forEach(function(dropdown) {
            dropdown.classList.add('hidden');
        });
    });

    function confirmDelete(event) {
        if (!confirm('Are you sure you want to delete this collaborator permanently?')) {
            event.preventDefault();
        }
    }
</script>

<!-- Styles -->
<style>
    /* Remove text decorations from links */
    a {
        text-decoration: none;
    }
    a:hover {
        text-decoration: none;
    }
</style>