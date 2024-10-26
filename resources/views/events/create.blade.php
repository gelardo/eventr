<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <!--- Create a form to create a new event ---->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <h2 class="text-2xl font-bold mb-1">{{ __("Create Event") }}</h2>
                </div>
                <!--- Show validation error --->
                @if ($errors->any())
                    <div class="p-6 text-red-500">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                    <form id="eventForm" action="{{ route('events.store') }}" method="POST">
                        @csrf
                        <div>
                            <label class="block mb-1">Title</label>
                            <input type="text" class="w-full border rounded p-2" required name="title">
                        </div>
                        <div>
                            <label class="block mb-1">Description</label>
                            <textarea class="w-full border rounded p-2" required name="description"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1">Start Date/Time</label>
                                <input type="datetime-local" class="w-full border rounded p-2" required name="start_datetime">
                            </div>
                            <div>
                                <label class="block mb-1">End Date/Time</label>
                                <input type="datetime-local" class="w-full border rounded p-2" required name="end_datetime">
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1">Attendees (comma-separated emails)</label>
                            <input type="text" id="attendeesInput" class="w-full border rounded p-2" required>
                            <!-- Hidden input to store the array format -->
                            <input type="hidden" name="attendees" id="attendeesArray">
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded hover:bg-blue-600">
                            Create Event
                        </button>
                    </form>
                </div>
            </div> 
        </div>
    </div>

    <script>
        document.getElementById('eventForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const attendeesValue = document.getElementById('attendeesInput').value;
            const attendeesArray = attendeesValue.split(',').map(email => email.trim());
            document.getElementById('attendeesArray').value = JSON.stringify(attendeesArray);
            console.log(attendeesArray);
            this.submit();
        });
    </script>
</x-app-layout>
