<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleRecommendation extends Model
{
    protected $table = 'schedule_recommendations';

    protected $fillable = [
        'schedule_id', 'content', 'sort_order',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
