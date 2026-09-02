<?php

namespace App\Models;

use Database\Factories\SubscriptionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['student_id', 'course_id', 'parent_id', 'status', 'valid_until', 'sessions_used', 'sessions_limit'])]
class subscription extends Model
{
    /** @use HasFactory<SubscriptionFactory> */
    use HasFactory;

    protected $casts = [
        'valid_until' => 'date',
        'sessions_used' => 'integer',
        'sessions_limit' => 'integer',
    ];

    protected $appends = [
        'sessions_left',
        'renewal_required',
    ];

    public function getSessionsLeftAttribute()
    {
        return max(0, ($this->sessions_limit ?? 0) - ($this->sessions_used ?? 0));
    }

    public function getRenewalRequiredAttribute()
    {
        return ($this->sessions_limit ?? 0) > 0 && ($this->sessions_used ?? 0) >= $this->sessions_limit;
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
