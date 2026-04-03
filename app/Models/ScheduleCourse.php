<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleCourse extends Model
{
    protected $table = 'schedule_courses';

    protected $fillable = [
        'schedule_id', 'day', 'name', 'code',
        'credits', 'class', 'lecturer',
        'time_start', 'time_end', 'room',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
