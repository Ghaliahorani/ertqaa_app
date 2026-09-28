<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'level',
        'registration_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(StudentAssignment::class);
    }

    public function notes()
    {
        return $this->hasMany(StudentNote::class);
    }
}
