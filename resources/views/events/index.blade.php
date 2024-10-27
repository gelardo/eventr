<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <!-- Import Events Section -->
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('events.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center">
                        <label class="text-gray-700 font-bold mr-4">{{ __("Import Events from CSV") }}</label>
                        <input type="file" name="csv_file" accept=".csv" required class="border rounded py-2 px-3">
                        <button type="submit" class="ml-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded border-b-4 border-green-700">
                            {{ __("Import") }}
                        </button>
                    </div>
                </form>
            </div>
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
        @else
            @if (session('success'))
                <div class="p-6 text-green-500">
                    {{ session('success') }}
                </div>
            @endif
        @endif

                
    </div>
    <!--- Create a responsive table for listing events ---->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div align="right" class="mb-4">
                        <a href="{{ route('events.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded border-b-4 border-blue-700">
                            {{ __("Create Event") }}
                        </a>
                    </div>

                    <!-- Responsive table container -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __("Reminder ID") }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __("Title") }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __("Start DateTime") }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __("End DateTime") }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __("Status") }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __("Attendees") }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __("Sync Status") }}
                                    </th>                                
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __("Options") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($events as $event)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $event->reminder_id }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500">
                                                {{ $event->title }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">
                                                {{ $event->start_datetime }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">
                                                {{ $event->end_datetime }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500">
                                                {{ $event->status }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500">
                                               @foreach ($event->attendees as $attendee)
                                                    {{ $attendee }}
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500">
                                                <!-- {{ $event->sync_status }} -->
                                                @if ($event->sync_status == 0)
                                                    <span class="text-red-500">Not Synced</span>
                                                @else
                                                    <span class="text-green">Synced</span>
                                                @endif
                                                    
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium">
                                            <a href="{{ route('events.show', $event) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ __("View") }}
                                            </a>
                                            <a href="{{ route('events.edit', $event) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ __("Edit") }}
                                            </a>
                                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-indigo-600 hover:text-indigo-900">
                                                    {{ __("Delete") }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
