<?php

namespace App\Imports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Jobs\SendEventEmail;

class EventsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        
       
        $emails = explode(',', $row['attendees']);
        // dd($emails);
        //validate email format
        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return null;
            }
        }
        if (empty($emails)) {
            return null;
        }        
        $event =  new Event([
            'title' => $row['title'],
            'description' => $row['description'] ?? null,
            'start_datetime' => $row['start_datetime'],
            'end_datetime' => $row['end_datetime'],
            'attendees' => $emails,
        ]);

        $event->save();
        foreach ($emails as $email) {
            SendEventEmail::dispatch($event);
        }
        return $event;
    }
}

