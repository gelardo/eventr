<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reminder_id',
        'title',
        'description',
        'start_datetime',
        'end_datetime',
        'status',
        'attendees',
        'is_synced'
    ];

    protected $casts = [
        'attendees' => 'array',
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'is_synced' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($event) {
            $event->reminder_id = self::generateReminderId();
        });
    }

    public static function generateReminderId()
    {
        $prefix = 'EVT';
        $timestamp = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return "{$prefix}-{$timestamp}-{$random}";
    }
}