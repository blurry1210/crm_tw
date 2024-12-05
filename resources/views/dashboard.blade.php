<x-app-layout>
   

    <style>
        a {
            text-decoration: none !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Dashboard Welcome Section -->
            
            <!-- Grid Layout for Sections -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Customer Management Section -->
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center ">
                    <h4 class="text-xl font-medium text-gray-800 mb-4">Customer Management</h4>
                    <a href="{{ route('customers.index') }}" class="bg-gray-900 text-white py-3 px-6 rounded-lg hover:bg-gray-800 transition w-full text-center dark:bg-gray-900 dark:hover:bg-gray-800">
                        Manage Customers
                    </a>    

                </div>

                <!-- Send Emails Section -->
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <h4 class="text-xl font-medium text-gray-800 mb-4">Email Campaigns</h4>
                    <a href="{{ route('emails.create') }}" class="bg-gray-900 text-white py-3 px-6 rounded-lg hover:bg-gray-800 transition w-full text-center dark:bg-gray-900 dark:hover:bg-gray-700">
                        Send Emails
                    </a>
                </div>

                <!-- Appointments Section -->
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <h4 class="text-xl font-medium text-gray-800 mb-4">Appointments</h4>
                    <a href="{{ route('calendar.index') }}" class="bg-gray-900 text-white py-3 px-6 rounded-lg hover:bg-gray-800 transition w-full text-center dark:bg-gray-900 dark:hover:bg-gray-700">
                        View Appointments
                    </a>
                </div>

                <!-- Placeholder Section for Future Features -->
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <h4 class="text-xl font-medium text-gray-800 mb-4">More Features</h4>
                    <p class="text-gray-600 mb-4">Coming soon...</p>
                    <a href="#" class="bg-gray-300 text-gray-700 py-3 px-6 rounded-lg transition w-full text-center">
                        Learn More
                    </a>
                </div>

                <!-- Collaborators Management Section -->
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center">
                    <h4 class="text-xl font-medium text-gray-800 mb-4">Collaborators Management</h4>
                    <a href="{{ route('collaborators.index') }}" class="bg-gray-900 text-white py-3 px-6 rounded-lg hover:bg-gray-800 transition w-full text-center dark:bg-gray-900 dark:hover:bg-gray-700">
                        Manage Collaborators
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
