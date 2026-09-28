<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_name',
        'description',
        'teacher_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
