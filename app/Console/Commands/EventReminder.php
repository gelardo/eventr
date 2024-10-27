<?php

namespace App\Console\Commands;

use App\Jobs\SendEventReminder;
use App\Mail\EventReminderEmail;
use Illuminate\Console\Command;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;

class EventReminder extends Command
{
    protected $signature = 'events:remind';
    protected $description = 'Send reminders for upcoming events and mark completed if ended';

    public function handle()
    {
        $now = now();
        $upcomingEvents = Event::where([['start_datetime', '>', $now], ['deleted_at', null]])->get();

        foreach ($upcomingEvents as $event) {
            // Send reminder email to attendees
            $attendees = $event->attendees;
            foreach ($attendees as $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                }
                // Mail::to(trim($email))->send(new EventReminderEmail($event));
                SendEventReminder::dispatch($event);
            }
        }

        $completedEvents = Event::where('start_datetime', '<=', $now)->where('status', '!=', 'completed')->get();
        foreach ($completedEvents as $event) {
            $event->status = 'completed'; 
            $event->save(); 
        }
        $this->info('Event reminders sent and statuses updated for completed events.');
    }
}
