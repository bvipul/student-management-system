<?php

namespace App\Repositories;

use App\Marks;

class MarksRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Marks::class;

    /**
     * @var Marks Model
     */
    protected $model;

    /**
     * @param MarksRepository $model
     */
    public function __construct(Marks $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin('courses', 'courses.id', '=', 'marks.course_id')
            ->leftjoin('users', 'users.id', '=', 'marks.student_id')
            ->leftjoin('semesters', 'semesters.id', '=', 'marks.semester_id')
            ->leftjoin('subjects', 'subjects.id', '=', 'marks.subject_id')
            ->select([
                'marks.id',
                'marks.course_id',
                'courses.name as courseName',
                'marks.student_id',
                'users.name as studentName',
                'marks.semester_id',
                'semesters.name as semesterName',
                'marks.subject_id',
                'subjects.name as subjectName',
                'marks.marks',
                'marks.updated_at',
                'marks.created_at'
            ]);
    }

    public function getMarks($course, $student, $semester, $subject) {
        return $this->query()
            ->select([
                'marks.id',
                'marks.course_id',
                'marks.student_id',
                'marks.semester_id',
                'marks.subject_id',
                'marks.marks',
                'marks.updated_at',
                'marks.created_at'
            ])
            ->where('course_id', $course)
            ->where('student_id', $student)
            ->where('semester_id', $semester)
            ->where('subject_id', $subject)
            ->first();
    }     
    
    public function create($input)
    {
        if(Marks::create($input))
        {
            return true;
        }
    }

    public function update($marks, $input)
    {
        if($marks->update($input))
        {
            return true;
        }
    }

    public function delete($marks)
    {
        if($marks->delete())
        {
            return true;
        }
    }
}