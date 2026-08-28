<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'monthly_fee', 'monthly_sessions', 'grade'])]
class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(subscription::class);
    }

    // Direct relationship via course_student pivot table (matching Student model)
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    // Students enrolled via Subscriptions table
    public function subscribedStudents()
    {
        return $this->hasManyThrough(Student::class, Subscription::class, 'course_id', 'id', 'id', 'student_id');
    }
}
