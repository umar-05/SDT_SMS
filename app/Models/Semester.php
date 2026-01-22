<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = ['name', 'is_current'];

    public function courses() {
        return $this->hasMany(Course::class);
    }

}
