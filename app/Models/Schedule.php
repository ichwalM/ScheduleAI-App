<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'user_id',
        'file_path',
        'file_disk',
        'ai_analysis_report',
        'status',
        // Normalized student info
        'student_name',
        'nim',
        'program',
        'semester',
        'advisor',
        'period',
        'total_credits',
        'conflict_count',
    ];

    /* ─── Relationships ─── */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->hasMany(ScheduleCourse::class)->orderByRaw("FIELD(day,'SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU')")->orderBy('time_start');
    }

    public function conflicts()
    {
        return $this->hasMany(ScheduleConflict::class);
    }

    public function recommendations()
    {
        return $this->hasMany(ScheduleRecommendation::class)->orderBy('sort_order');
    }

    public function activities()
    {
        return $this->hasMany(ScheduleExternalActivity::class)->orderByRaw("FIELD(day,'SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU')")->orderBy('time_start');
    }
}
