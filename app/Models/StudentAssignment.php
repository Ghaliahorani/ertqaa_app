<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAssignment extends Model
{
    protected $fillable = [
        'student_id',
        'assignment_id',
        'file_path',
        'submitted_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function grade()
    {
        return $this->hasOne(Grade::class);
    }
}

