<?php


namespace App\Jobs;

use App\Models\Event;
use App\Mail\EventEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEventReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function handle()
    {
        foreach ($this->event->attendees as $attendee) {
            // dd($attendee);
            Mail::to($attendee)->send(new EventEmail($this->event));
        }
    }
}
