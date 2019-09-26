<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SubjectResource extends Resource
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
            'id'              => $this->id,
            'course_id'       => $this->course_id,
            'course_name'     => $this->courseName,
            'semester_id'     => $this->semester_id,
            'semester_name'   => $this->semesterName,
            'name'            => $this->name,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at
        ];
    }
}
