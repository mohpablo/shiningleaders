<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['group_id', 'student_id', 'session_number', 'attendance', 'homework_status', 'comment'])]
class GroupStudentSession extends Model
{
    use HasFactory;

    protected $table = 'group_student_sessions';

    protected function casts(): array
    {
        return [
            'attendance' => 'boolean',
            'session_number' => 'integer',
        ];
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
