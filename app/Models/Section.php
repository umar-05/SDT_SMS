<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['course_id', 'name', 'capacity', 'room', 'schedule'];

    // A section belongs to one course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // A section has many registrations
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}