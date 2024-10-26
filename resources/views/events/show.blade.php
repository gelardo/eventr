<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <!--- Show the event details ---->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <h2 class="text-2xl font-bold mb-1">{{ __("Event Details") }}</h2>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold text-gray-700">Title</label>
                        <p class="text-gray-900">{{ $event->title }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold text-gray-700">Description</label>
                        <p class="text-gray-900">{{ $event->description }}</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">Start Date/Time</label>
                            <p class="text-gray-900">{{ $event->start_datetime }}</p>
                        </div>
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">End Date/Time</label>
                            <p class="text-gray-900">{{ $event->end_datetime }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Attendees</label>
                        <p class="text-gray-900">{{ $event->attendees }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector("form").addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = {
            title: document.querySelector("[name='title']").value,
            description: document.querySelector("[name='description']").value,
            start_datetime: document.querySelector("[name='start_datetime']").value,
            end_datetime: document.querySelector("[name='end_datetime']").value,
            attendees: document.querySelector("[name='attendees']").value,
        };

        if (navigator.onLine) {
            // Submit data if online
            fetch('/events/store', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
            }).then(response => response.json())
            .then(data => console.log("Event created:", data))
            .catch(error => console.error("Failed to create event:", error));
        } else {
            // Store form data offline if not connected
            const db = await openDB();
            const tx = db.transaction("events", "readwrite");
            const store = tx.objectStore("events");
            await store.add(formData);

            // Register background sync
            if ('serviceWorker' in navigator && 'SyncManager' in window) {
            const registration = await navigator.serviceWorker.ready;
            await registration.sync.register("sync-events");
            console.log("Event saved offline and will sync when online.");
            }
        }
        });

        async function openDB() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open("EventDB", 1);
            request.onerror = () => reject("Could not open database");
            request.onsuccess = () => resolve(request.result);
            request.onupgradeneeded = (event) => {
            const db = event.target.result;
            db.createObjectStore("events", { keyPath: "id", autoIncrement: true });
            };
        });
        }

    </script>
</x-app-layout>
