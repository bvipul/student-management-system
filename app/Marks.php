<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id', 'student_id', 'semester_id', 'subject_id', 'marks'
    ];

    public function course() {
    	return $this->belongsTo(\App\Course::class);
    }

    public function student() {
    	return $this->belongsTo(\App\User::class, 'student_id');
    }

    public function semester() {
    	return $this->belongsTo(\App\Semester::class, 'semester_id');
    }

    public function subject() {
    	return $this->belongsTo(\App\Subject::class, 'subject_id');
    }
}
