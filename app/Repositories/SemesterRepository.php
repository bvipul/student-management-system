<?php

namespace App\Repositories;

use App\Semester;

class SemesterRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Semester::class;

    /**
     * @var Semester Model
     */
    protected $model;

    /**
     * @param SemesterRepository $model
     */
    public function __construct(Semester $model)
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
                'semesters.id',
                'semesters.name',
                'semesters.updated_at',
                'semesters.created_at'
            ]);
    }     
    
    public function create($input)
    {
        if(Semester::create($input))
        {
            return true;
        }
    }

    public function update($semester, $input)
    {
        if($semester->update($input))
        {
            return true;
        }
    }

    public function delete($semester)
    {
        if($semester->delete())
        {
            return true;
        }
    }
}