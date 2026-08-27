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

    public function students()
    {
        return $this->hasManyThrough(Student::class, subscription::class, 'course_id', 'id', 'id', 'student_id');
    }
}
