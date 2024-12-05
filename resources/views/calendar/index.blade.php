<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight text-center">
            {{ __('Appointments Agenda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="flex justify-between items-center p-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Event Calendar</h3>
                    <a href="{{ route('calendar.create') }}" class="font-bold py-2 px-4 rounded-lg shadow-md text-white" style="background-color: #1e40af; border: 2px solid #1e40af;">
                        Add Event
                    </a>
                </div>
                <div class="p-6 bg-white">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var events = {!! json_encode($events->map(function($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->customer->first_name . ' ' . $event->customer->last_name,
                    'start' => $event->date . 'T' . $event->start_time,
                    'end' => $event->date . 'T' . $event->end_time
                ];
            })) !!};

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: events,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                eventClick: function(info) {
                    window.location.href = '/calendar/' + info.event.id + '/edit';
                }
            });
            calendar.render();
        });
    </script>
</x-app-layout>
