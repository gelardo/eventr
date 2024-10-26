<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Jobs\SendEventReminders;
use App\Imports\EventsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = $events = Event::orderBy('start_datetime')->get();

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'attendees' => 'required|string', // Will process this later
        ]);
        $attendees = json_decode($validatedData['attendees'], true);
           // Validate each email format
        foreach ($attendees as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->withErrors(['attendees' => "Invalid email format: $email"])->withInput();
            }
        }
        
        $event = Event::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'start_datetime' => $validatedData['start_datetime'],
            'end_datetime' => $validatedData['end_datetime'],
            'attendees' => $attendees, 
        ]);

        SendEventReminders::dispatch($event);
        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }


    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:xlsx',
        ]);

        Excel::import(new EventsImport, $request->file('csv_file'));

        return redirect()->route('events.index')->with('success', 'Events imported successfully.');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date',
            'attendees' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
