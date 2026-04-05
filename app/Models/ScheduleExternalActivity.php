<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleExternalActivity extends Model
{
    protected $fillable = [
        'schedule_id',
        'type',
        'title',
        'day',
        'time_start',
        'time_end',
        'description',
        'location',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
