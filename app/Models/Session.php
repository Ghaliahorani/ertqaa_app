<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'course_id',
        'session_date',
        'start_time',
        'end_time',
        'location'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

