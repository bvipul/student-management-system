<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MarksResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'course_id'         => $this->course_id,
            'course_name'       => $this->courseName,
            'student_id'        => $this->student_id,
            'student_name'      => $this->studentName,
            'semester_id'       => $this->semester_id,
            'semester_name'     => $this->semesterName,
            'subject_id'        => $this->subject_id,
            'subject_name'      => $this->subjectName,
            'marks'             => $this->marks,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at
        ];
    }
}
