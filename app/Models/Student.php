<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'parent_id',
    'name',
    'age',
    'phone_number',
    'school',
    'academic_year',
])]
class Student extends Model
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_student')
            ->withPivot('enrollment_date', 'attendance', 'homework_completed', 'comment');
    }

    public function subscriptions()
    {
        return $this->hasMany(subscription::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
