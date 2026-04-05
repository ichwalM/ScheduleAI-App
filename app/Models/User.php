<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Get the schedules for the user.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Send the password reset notification (Indonesian email).
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the email verification notification (Indonesian email).
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Get all courses for the user through schedules.
     */
    public function allCourses()
    {
        return $this->hasManyThrough(ScheduleCourse::class, Schedule::class);
    }

    /**
     * Get all external activities for the user through schedules.
     */
    public function allActivities()
    {
        return $this->hasManyThrough(ScheduleExternalActivity::class, Schedule::class);
    }

    /* ─── Custom Methods ─── */

    public function getAllItems()
    {
        $this->loadMissing(['schedules.courses', 'schedules.activities']);
        $items = collect();
        foreach ($this->schedules as $s) {
            $items = $items->concat($s->courses->map(function ($c) {
                $c->is_activity = false;
                return $c;
            }));
            $items = $items->concat($s->activities->map(function ($a) {
                $a->is_activity = true;
                return $a;
            }));
        }
        return $items->sortBy('time_start');
    }

    public function getGlobalConflictsAttribute()
    {
        $items   = $this->getAllItems();
        $conflicts = collect();
        $grouped   = $items->groupBy('day');

        foreach ($grouped as $day => $dayItems) {
            $sorted = $dayItems->sortBy('time_start')->values();
            for ($i = 0; $i < $sorted->count(); $i++) {
                $curr = $sorted[$i];
                for ($j = $i + 1; $j < $sorted->count(); $j++) {
                    $next = $sorted[$j];
                    if ($curr->time_end > $next->time_start) {
                        $conflicts->push(['item1' => $curr, 'item2' => $next]);
                    }
                }
            }
        }
        return $conflicts;
    }
}
