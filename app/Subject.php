<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id', 'semester_id', 'name'
    ];

    public function course() {
    	return $this->belongsTo(\App\Course::class);
    }

    public function semester() {
    	return $this->belongsTo(\App\Semester::class);
    }
}
