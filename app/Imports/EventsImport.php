<?php

namespace App\Imports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EventsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Event([
            'title' => $row['title'],
            'description' => $row['description'] ?? null,
            'start_datetime' => $row['start_datetime'],
            'end_datetime' => $row['end_datetime'],
            'attendees' => explode(',', $row['attendees']),
        ]);
    }
}

