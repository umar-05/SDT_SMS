<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_code', 
        'title', 
        'description', 
        'max_students', // Ensure this is here
        'lecturer_id', 
        'semester_id'
    ];

    public function lecturer() {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function semester() {
        return $this->belongsTo(Semester::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    // This helps your Blade file count registrations across all sections
    public function registrations()
    {
        return $this->hasManyThrough(Registration::class, Section::class);
    }
}
