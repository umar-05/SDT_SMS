<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['course_code', 'title', 'description', 'max_students', 'lecturer_id', 'semester_id'];

    public function lecturer() {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function semester() {
        return $this->belongsTo(Semester::class);
    }

    public function registrations() {
        return $this->hasMany(Registration::class);
    }
}
