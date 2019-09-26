<?php

namespace App\Repositories;

use App\Subject;

class SubjectRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Subject::class;

    /**
     * @var Subject Model
     */
    protected $model;

    /**
     * @param SubjectRepository $model
     */
    public function __construct(Subject $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin('courses', 'courses.id', '=', 'subjects.course_id')
            ->leftjoin('semesters', 'semesters.id', '=', 'subjects.semester_id')
            ->select([
                'subjects.id',
                'subjects.course_id',
                'courses.name as courseName',
                'subjects.semester_id',
                'semesters.name as semesterName',
                'subjects.name',
                'subjects.updated_at',
                'subjects.created_at'
            ]);
    }     

    public function getSubjects($course, $semester) {
        return $this->query()
            ->select([
                'subjects.id',
                'subjects.course_id',
                'subjects.semester_id',
                'subjects.name',
                'subjects.updated_at',
                'subjects.created_at'
            ])
            ->where('course_id', $course)
            ->where('semester_id', $semester)
            ->get();
    }
    
    public function create($input)
    {
        if(Subject::create($input))
        {
            return true;
        }
    }

    public function update($subject, $input)
    {
        if($subject->update($input))
        {
            return true;
        }
    }

    public function delete($subject)
    {
        if($subject->delete())
        {
            return true;
        }
    }
}