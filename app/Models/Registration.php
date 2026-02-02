<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    // course_id is removed because it now lives in the sections table
    protected $fillable = ['student_id', 'section_id', 'status'];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }

    // Logic to get Course through Section
    public function course() {
        return $this->hasOneThrough(Course::class, Section::class, 'id', 'id', 'section_id', 'course_id');
    }
}