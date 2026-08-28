<?php

namespace App\Models;

use Database\Factories\GroupFactory;
use App\Models\GroupStudentSession;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['course_id', 'teacher_id', 'name', 'schedule'])]
class Group extends Model
{
    /** @use HasFactory<GroupFactory> */
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'group_student')
            ->withPivot('enrollment_date', 'attendance', 'homework_completed', 'comment');
    }

    public function sessionRecords()
    {
        return $this->hasMany(GroupStudentSession::class);
    }
}
