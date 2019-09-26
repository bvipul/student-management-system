<?php

namespace App\Repositories;

use App\Course;

class CourseRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Course::class;

    /**
     * @var Course Model
     */
    protected $model;

    /**
     * @param CourseRepository $role
     */
    public function __construct(Course $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select([
                'courses.id',
                'courses.name',
                'courses.updated_at',
                'courses.created_at'
            ]);
    }     
    
    public function create($input)
    {
        if(Course::create($input))
        {
            return true;
        }
    }

    public function update($course, $input)
    {
        if($course->update($input))
        {
            return true;
        }
    }

    public function delete($course)
    {
        if($course->delete())
        {
            return true;
        }
    }
}