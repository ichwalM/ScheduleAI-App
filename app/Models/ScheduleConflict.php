<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleConflict extends Model
{
    protected $table = 'schedule_conflicts';

    protected $fillable = [
        'schedule_id', 'day', 'description', 'courses_involved',
    ];

    protected $casts = [
        'courses_involved' => 'array',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
