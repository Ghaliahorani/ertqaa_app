<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_assignment_id',
        'grade',
        'teacher_note'
    ];

    public function studentAssignment()
    {
        return $this->belongsTo(StudentAssignment::class);
    }
}

